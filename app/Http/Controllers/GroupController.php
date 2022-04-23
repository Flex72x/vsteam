<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::limit(5)->get();
        return view('admin.group.index', compact('groups'));
    }

    public function store(Request $request)
    {
        Group::create([
            'name'=>$request->name,
        ]);

        return response()->json(['success'=>true]);
    }

    public function getGroups(Request $request)
    {
        $page = $request->page;
        $groups = Group::orderBy('created_at', 'desc')->offset($page*5)->limit(6);
        $request->text ? $groups = $groups->where('name','LIKE', "%".$request->text."%")->get() : $groups = $groups->get(); 
        if(count($groups) <=5) {
            $end = true;
        } else {
            $end = false;
        }
        $groups = $groups->take(5);
        $data = view('admin.group.ajax.get_groups', compact('groups'))->render();
        return response()->json(['data'=>$data, 'end'=>$end]);
    }

    public function edit(Request $request)
    {
        $group = Group::findOrFail($request->id);
        return response()->json(['data'=>$group]);
    }

    public function update(Request $request)
    {
        $group = Group::findOrFail($request->id);
        $group->name = $request->name;
        $group->slug = null;
        $group->save();
    }

    public function delete(Request $request)
    {
        $group = Group::findOrFail($request->id);
        $group->delete();
    }
}