<?php

namespace App\Http\Controllers;

use Pusher\Pusher;
use App\Models\Task;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function save_task(Request $request)
    {
        $task = new Task;
        $task->title = $request['title'];
        $task->description = $request['description'];
        $title = $request->title;

        $report = new Report;
        $report->user_id = Auth::user()->id;
        $id = $report->user_id;
        $report->note = $title;
        $report->save();

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = [
            'user_id' => $id,
            'notes' => $report->note
        ];
        $pusher->trigger('my-channel', 'my-event', $data);

        if($task->save()){
            return response()->json([
                'status' => true,
                'message' => 'Task Added Successfully'
            ]);
        }
    }
}
