<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Services\ZoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::where('senior_id', Auth::user()->id)->latest()->get();

        return view('senior.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('senior.meetings.create');
    }

    public function store(Request $request, ZoomService $zoom)
    {

        $meetingData = $zoom->createMeeting(
            $request->topic,
            $request->start_time,
            $request->duration,
            $request->agenda ?? ''
        );
        // dd($meetingData);
        $lastRecord = Meeting::latest()->first();
        // dd($lastRecord);
        if ($lastRecord != null) {
            Meeting::where('id', $lastRecord->id)->update([
                'is_active' => 1,
            ]);
        }

        //  dd
        Meeting::create([
            'senior_id' => Auth::user()->id,
            'created_by' => Auth::id(),
            'topic' => $request->topic,
            'agenda' => $request->agenda,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'zoom_meeting_id' => $meetingData['id'],
            'join_url' => $meetingData['join_url'],
            'start_url' => $meetingData['start_url'],
        ]);

        return redirect()->route('senior.meetings.index')->with('success', 'Meeting created successfully.');
    }

    public function show(Meeting $meeting)
    {
        return view('senior.meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        return view('senior.meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'agenda' => 'nullable|string',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:15|max:180',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);

        $meeting->update($request->all());

        return redirect()->route('senior.meetings.index')->with('success', 'Meeting updated.');
    }

    public function destroy($meeting)
    {
        // $meeting->delete();
        Meeting::where('id', $meeting)->update(array(
            'is_active' => 1
        ));
        return redirect()->route('senior.meetings.index')->with('success', 'Meeting deleted.');
    }
}
