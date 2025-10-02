<?php

namespace App\Http\Controllers;

use App\Models\VoiceJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoiceJournalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $journals = VoiceJournal::where('senior_id', auth()->user()->id)->latest()->get();

        return view('senior.voice_journal.index', compact('journals'));
    }

    public function create()
    {
        return view('senior.voice_journal.create');
    }

    public function store(Request $request)
    {
            // $request->validate([
            //     'recorded_voice' => 'required|mimes:mp3,wav,ogg|max:10240', // 10MB
            //     'title' => 'nullable|string|max:255',
            // ]);
        
        // dd($request->all());
        $audioData = $request->recorded_voice;
        $audioData = explode(',', $audioData)[1]; // remove "data:audio/webm;base64,"
        $audioData = base64_decode($audioData);

        $webmFile = 'voice_journals/'.uniqid().'.webm';
        
         // 3. Convert to MP3 using ffmpeg
        $mp3File = str_replace('.webm', '.mp3', $webmFile);
        $webmPath = storage_path('app/public/'.$webmFile);
        $mp3Path = storage_path('app/public/'.$mp3File);

        // 2. Save as temporary .webm file
        Storage::disk('public')->put($webmFile, $audioData);

       
 
        // Run ffmpeg command
        // dd($mp3Path);
        exec("ffmpeg -i {$webmPath} -vn -ar 44100 -ac 2 -b:a 192k {$mp3Path}");

        // 4. Save to DB
        VoiceJournal::create([
            'senior_id' => auth()->user()->id,
            'created_by' => auth()->id(),
            'title' => $request->title,
            'file_path' => $webmFile, // store mp3 instead of webm
        ]);

        return redirect()->route('senior.voice-journal.index')->with('success', 'Voice journal saved.');
    }
}
