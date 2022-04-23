<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discipline;
use Illuminate\Support\Facades\Validator;
use App\Models\Group;

class DisciplineController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('admin.discipline.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|',
            'group_id'=>'required|',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>true]);
        }

        $discipline = Discipline::create([
            'name'=>$request->name,
            'group_id'=>$request->group_id,
        ]);

        return response()->json(['success'=>true]);
    }

    public function getDisciplines(Request $request)
    {
        $disciplines = Discipline::offset($request->page*5)->limit(6);
        if($request->text) {
            $disciplines = $disciplines->where('name', 'LIKE', '%'.$request->text.'%');
        }
        if($request->group_id) {
            $disciplines = $disciplines->where('group_id', $request->group_id);
        }
        $disciplines = $disciplines->get();

        count($disciplines) <= 5 ? $end = true : $end = false;

        $data = view('admin.discipline.ajax.get_disciplines', compact('disciplines'))->render();
        return response()->json(['data'=>$data, 'end'=>$end]);
    }

    public function edit(Request $request)
    {
        $discipline = Discipline::findOrFail($request->id);
        $group_id = $discipline->groups->id;
        return response()->json(['data'=>$discipline, 'group'=>$group_id]);
    }

    public function update(Request $request)
    {
        $discipline = Discipline::findOrFail($request->id);
        $discipline->name = $request->name;
        $discipline->group_id = $request->group_id;
        $discipline->slug = null;
        $discipline->save();
        return response()->json(['success'=>true]);
    }
    public function delete(Request $request)
    {
        $discipline = Discipline::findOrFail($request->id);
        $discipline->delete();
        return response()->json(['success'=>true]);
    }
}
