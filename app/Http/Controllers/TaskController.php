<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use App\Models\Discipline;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $disciplines = Discipline::all();
        return view('admin.task.index', compact('disciplines'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required',
            'text'=>'required',
            'type'=>'required',
            'discipline_id'=>'required',
            'img' => 'required|image',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>true]);
        }

        $img = $request->file('img')->store('tasks_images', 'public');

        Task::create([
            'title'=>$request->title,
            'text'=>$request->text,
            'type'=>$request->type,
            'discipline_id'=>$request->discipline_id,
            'img'=>$img,
        ]);

        return response()->json(['success'=>true]);
    }

    public function getTasks(Request $request)
    {
        $tasks = Task::orderBy('created_at', 'DESC')->offset($request->page*5)->limit(6);
        if($request->text) {
            $tasks = $tasks->where('title', 'LIKE', '%'.$request->text.'%');
        }
        if($request->discipline_id) {
            $tasks = $tasks->where('discipline_id', $request->discipline_id);
        }
        $tasks = $tasks->get();
        count($tasks) <= 5 ? $end = true : $end = false;
        $data = view('admin.task.ajax.get_tasks', compact('tasks'))->render();
        return response()->json(['data'=>$data, 'end'=>$end]);
    }

    public function edit(Request $request)
    {
        $task = Task::findOrFail($request->id);
        return response()->json(['data'=>$task]);
    }

    public function update(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->title = $request->title;
        $task->text = $request->text;
        $task->type = $request->type;
        $task->discipline_id = $request->discipline_id;
        $task->slug = null;

        if(!empty($request->img)) {
            Storage::disk('public')->delete($task->img);
            $img = $request->file('img')->store('tasks_images', 'public');
            $task->img = $img;
        }

        $task->save();
        return response()->json(['success'=>true]);
    }

    public function delete(Request $request)
    {
        $task = Task::findOrFail($request->id);
        Storage::disk('public')->delete($task->img);
        $task->delete();
        return response()->json(['success'=>true]);
    }
}
