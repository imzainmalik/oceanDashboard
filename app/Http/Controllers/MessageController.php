<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $user_details = User::whereIn('id', $request->sender_id)->first();

            if ($request->sender_id == auth()->user()->id) {
                $reciver_details = User::where('id', str_replace("user_id_", '', $request->receiver_id))->first();
            } else {
                $reciver_details = User::where('id', $request->sender_id)->first();
            }
            return $reciver_details;
        }
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        if ($tenant == null) {
            $chat_room = ChatRoom::where('family_owner_id', auth()->user()->id)->first();
            $owner_id = auth()->user()->id;
        } else {
            $chat_room = ChatRoom::where('family_owner_id', $tenant->owner_id)->first();
            $owner_id = $tenant->owner_id;
        }

        $get_all_tenant = Tenant::where('owner_id', $owner_id)->pluck('child_id')->toArray();
        $family_members = User::whereIn('id', $get_all_tenant)->get();
        // dd($get_all_tenant);


        // Fetch 2 latest from each type (you can adjust)
        $voiceNotes = DB::table('voice_journals')
            ->select('id', 'title', 'created_at')
            ->latest()
            ->take(2)
            ->get()
            ->map(fn($v) => [
                'type' => 'Voice Note',
                'title' => $v->title,
                'date' => $v->created_at,
                'badge' => 'info',
            ]);

        $bills = DB::table('bills')
            ->select('id', 'title', 'created_at')
            ->latest()
            ->take(2)
            ->get()
            ->map(fn($b) => [
                'type' => 'Bill',
                'title' => 'Bill title: ' . $b->title . ' ',
                'date' => $b->created_at,
                'badge' => 'warning',
            ]);

        $docs = DB::table('document_requests')
            ->select('id', 'title', 'created_at')
            ->latest()
            ->take(2)
            ->get()
            ->map(fn($d) => [
                'type' => 'Document Request',
                'title' => 'Document: ' . $d->title,
                'date' => $d->created_at,
                'badge' => 'secondary',
            ]);

        $tasks = DB::table('tasks')
            ->select('id', 'title', 'created_at')
            ->latest()
            ->take(2)
            ->get()
            ->map(fn($t) => [
                'type' => 'New Task',
                'title' => $t->title,
                'date' => $t->created_at,
                'badge' => 'success',
            ]);

        // Merge all collections
        $combined = $voiceNotes
            ->merge($bills)
            ->merge($docs)
            ->merge($tasks);

        // Sort by latest and pick random 4
        $latestFour = $combined
            ->sortByDesc('date')
            ->take(10) // take latest few
            ->shuffle() // randomize order
            ->take(4); // pick 4 random

        return view('message.index', compact('chat_room', 'family_members', 'latestFour'));
    }

    public function create_chat_room()
    {
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        if ($tenant == null) {
            $owner_id = auth()->user()->id;
        } else {
            $owner_id = $tenant->owner_id;
        }
        $rand_room_id = substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(20))), 0, 32); // 32 characters, without /=+
        // dd($string);
        $chat_room = new ChatRoom;
        $chat_room->family_owner_id = $owner_id;
        $chat_room->room_id =  $rand_room_id;
        $chat_room->save();

        return redirect()->route('message.family_chat', $rand_room_id)->with('success', 'Family chat created');
    }

    public function family_chat($roomId)
    {
        $chat_room = ChatRoom::where('room_id', $roomId)->first();
        return view('message.family_chat', compact('roomId'));
    }
}
