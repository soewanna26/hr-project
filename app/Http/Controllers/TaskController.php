<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function taskData(Request $request)
    {
        $project = Project::with('tasks')->where('id', $request->project_id)->first();
        return view('components.task', compact('project'))->render();
    }
    public function store(Request $request)
    {
        $task = new Task();
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->save();

        $task->members()->sync($request->members);
        return 'success';
    }
    public function update($id,Request $request)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->update();

        $task->members()->sync($request->members);
        return 'success';
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task ->members()->detach();
        $task->delete();
        return 'success';
    }
}
