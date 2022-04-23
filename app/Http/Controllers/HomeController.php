<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Group;
use App\Models\Discipline;
use App\Models\Task;

class HomeController extends Controller
{
    public function index_admin()
    {
        return view('admin.welcome');
    }

    public function index()
    {
        $news = News::orderBy('created_at', 'DESC')->limit(9)->get();
        $groups = Group::all();
        return view('index', compact('news', 'groups'));
    }

    public function show_news($slug)
    {
        $groups = Group::all();
        $news = News::where('slug', $slug)->firstOrFail();
        return view('news', compact('news', 'groups'));
    }

    public function show_group($slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        $groups = Group::all();
        $disciplines = $group->disciplines;
        $tasks = Task::whereIn('discipline_id', $disciplines->pluck('id')->toArray())->orderBy('created_at', 'DESC')->get();

        return view('group', compact('group', 'groups', 'disciplines', 'tasks'));
    }

    public function show_tasks($groupSlug, $disciplineSlug, $typeSlug=null)
    {
        $group = Group::where('slug', $groupSlug)->firstOrFail();
        $discipline = Discipline::where('slug', $disciplineSlug)->firstOrFail();
        $disciplines = $group->disciplines;
        if($discipline->group_id != $group->id) {
            abort(404);
        }
        $groups = Group::all();
        $tasks = Task::where('discipline_id', $discipline->id);

        if($typeSlug == 'lecture') {
            $tasks = $tasks->where('type', 1)->get();
            return view('lecture', compact('groups', 'group', 'discipline', 'tasks', 'disciplines'));
        } else if($typeSlug =='practica') {
            $tasks = $tasks->where('type', 2)->get();
            return view('practica', compact('groups', 'group', 'discipline', 'tasks', 'disciplines'));
        } else {
            abort(404);
        }
    }
}

