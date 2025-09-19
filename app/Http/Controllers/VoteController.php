<?php
namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\PoolVoting;
use App\Models\VotingPool;
use App\Models\Vote;
use Illuminate\Http\Request;
use Auth;

class VoteController extends Controller
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

    public function store(Request $request, $voting)
    {
        $request->validate([
            'choice' => 'required|in:yes,no,abstain',
            'comment' => 'nullable|string|max:1000'
        ]);

        $PoolVoting_details = Pool::where('id', $voting)->first();
        $user = auth()->user();

        // check if voting open
        if(!$PoolVoting_details->isOpen()) {
            return back()->with('error','Voting is closed.');
        }

        $vote = PoolVoting::updateOrCreate(
            ['pool_id'=>$PoolVoting_details->id, 'user_id'=>$user->id],
            ['choice'=>$request->choice, 'comment'=>$request->comment]
        );
        
        return back()->with('success','Your vote recorded.');
    }
}
