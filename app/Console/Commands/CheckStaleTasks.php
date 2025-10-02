<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckStaleTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check-stale-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark tasks as need_outside_help if not acted on within 2 days';

    /**
     * Execute the console command.
     */


    public function handle()
    {
        
        $tasks = Task::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subDays(2))
            ->get();


        // if ($this->option('dry-run')) {
        //     $this->info("Dry run: Found " . $tasks->count() . " expired tasks.");
        //     return;
        // }
        // dd($tasks);

        foreach ($tasks as $task) {
            // $task->status = 'need_outside_help';
            // $task->assignee_id = null;
            // $task->save();
            Task::where('id', $task->id)->update(array(
                'assignee_id' => null,
                'status' => 'need_outside_help'
            ));
            // Broadcast notification (if needed)
            // broadcast(new \App\Events\TaskEscalated($task));
        }

        $this->info('Stale tasks updated successfully.');
    }
}
