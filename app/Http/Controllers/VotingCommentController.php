<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\VotingComment;
use App\Models\Pool;
class VotingCommentController extends Model
{
    //

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


      public function store(Request $request, $pool)
    {
        $pool_details = Pool::where('id', $pool)->first();
        // dd($pool_details);
        $request->validate([
            'message'=>'required|string|max:2000',
            'parent_id'=>'nullable|exists:voting_comments,id'
        ]);

        $comment = VotingComment::create([
            'pool_id' => $pool_details->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'message' => $request->message,
        ]);
        //  dd($comment);   
        return back()->with('success','Comment added.');
    }
}
