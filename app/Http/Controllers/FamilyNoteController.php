<?php

namespace App\Http\Controllers;

use App\Models\FamilyNote;
use App\Models\FamilyOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyNoteController extends Controller
{
    public function index()
    {
        $ownerId = FamilyOwner::where('owner_id', Auth::id())->value('id');
        $notes = FamilyNote::where('family_owner_id', $ownerId)->latest()->paginate(10);
        return view('family_owner.family_notes.index', compact('notes'));
    }

    public function create()
    {
        return view('family_owner.family_notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:note,feedback',
            'visibility' => 'required|in:private,family',
        ]);

        $ownerId = FamilyOwner::where('owner_id', Auth::id())->value('id');

        FamilyNote::create([
            'family_member_id' => auth()->user()->id,
            'family_owner_id' => $ownerId,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'visibility' => $request->visibility,
        ]);

        return redirect()->route('familyOwner.family-notes.index')->with('success', 'Note created successfully.');
    }

    public function show(FamilyNote $familyNote)
    {
        return view('family_owner.family_notes.show', compact('familyNote'));
    }

    public function edit(FamilyNote $familyNote)
    {
        return view('family_owner.family_notes.edit', compact('familyNote'));
    }

    public function update(Request $request, FamilyNote $familyNote)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:note,feedback',
            'visibility' => 'required|in:private,family',
        ]);

        $familyNote->update($request->all());

        return redirect()->route('familyOwner.family-notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(FamilyNote $familyNote)
    {
        $familyNote->delete();
        return redirect()->route('familyOwner.family-notes.index')->with('success', 'Note deleted successfully.');
    }
}
