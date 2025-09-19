<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\EmergencyDocument;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentRequestController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $requests = DocumentRequest::where('family_owner_id', auth()->user()->id)
            ->orderBy('id', 'DESC')->get();

        return view('documents.index', compact('requests'));
    }

    public function create(Request $request)
    {
        $users = Tenant::where('owner_id', auth()->user()->id)
            ->whereHas('users', function ($q) {
                $q->where('account_status', 0);
                $q->orwhere('account_status', 1);
            })
            ->orderBy('id', 'DESC')
            ->get();

        // dd($users->owner);
        return view('documents.create', compact('users'));
    }

    public function storeRequest(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'nullable|string|max:2000',
            'deadline_minutes' => 'required|integer|min:5|max:10080',
        ]);

        $expiresAt = Carbon::now()->addMinutes((int) $request->deadline_minutes);

        $docReq = DocumentRequest::create([
            'family_owner_id' => Auth::id(),
            'requester_id' => Auth::id(),
            'target_user_id' => (int) $request->target_user_id,
            'title' => $request->title,
            'message' => $request->message,
            'expires_at' => $expiresAt,
            'status' => 'pending',
            'type' => $request->doc_type
        ]);

        $target_user = User::find((int) $request->target_user_id);
        make_log(auth()->user()->id, auth()->user()->name, 'Document Requested', ' '.auth()->user()->name.' Requested for Document to '.$target_user->name.'');

        // dd($docReq);
        return redirect()->route('document.requests.all')->with('success', 'Document request sent.');
    }

    public function show(DocumentRequest $documentRequest)
    {
        $user = Auth::user();
        if (! in_array($user->id, [$documentRequest->requester_id, $documentRequest->target_user_id]) && $user->role->name !== 'super_admin') {
            abort(403);
        }

        if ($documentRequest->status === 'pending' && $documentRequest->isExpired()) {
            $documentRequest->status = 'expired';
            $documentRequest->save();
        }

        return view('documents.show', compact('documentRequest'));
    }

    public function submitDocument(Request $request, DocumentRequest $documentRequest)
    {
        $user = Auth::user();
        if ($user->id !== $documentRequest->target_user_id) {
            abort(403);
        }

        if ($documentRequest->status !== 'pending' || $documentRequest->isExpired()) {
            return redirect()->back()->with('error', 'This request is no longer open.');
        }

        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('emergency_documents');
        $doc = EmergencyDocument::create([
            'uploader_id' => $user->id,
            'original_name' => $file->getClientOriginalName(),
            'disk_path' => $path,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'is_private' => true,
        ]);

        $documentRequest->document_id = $doc->id;
        $documentRequest->status = 'submitted';
        $documentRequest->save();

        $target_user = User::find((int) $request->target_user_id);
        make_log(auth()->user()->id, auth()->user()->name, 'Document Requested', ' '.auth()->user()->name.' Requested for Document to '.$target_user->name.'');

        return redirect()->back()->with('success', 'Document submitted successfully.');
    }

    public function download(DocumentRequest $documentRequest)
    {
        $user = Auth::user();
        $doc = $documentRequest->document;
        if (! $doc) {
            abort(404);
        }

        if (! in_array($user->id, [$documentRequest->requester_id, $documentRequest->target_user_id]) && $user->role->name !== 'super_admin') {
            abort(403);
        }

        return Storage::download($doc->disk_path, $doc->original_name);
    }

    public function cancel(DocumentRequest $documentRequest)
    {
        $user = Auth::user();
        if ($user->id !== $documentRequest->requester_id && $user->role->name !== 'super_admin') {
            abort(403);
        }

        $documentRequest->status = 'cancelled';
        $documentRequest->save();

        return redirect()->back()->with('success', 'Request cancelled.');

    }
}
