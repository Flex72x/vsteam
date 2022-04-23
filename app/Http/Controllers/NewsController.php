<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        return view('admin.news.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'text' => 'required',
            'img' => 'required|image',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>true]);
        }

        $img = $request->file('img')->store('news_images', 'public');
        $news = News::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'text'=>$request->text,
            'img'=>$img,
        ]);
        return response()->json(['success'=>true]);
    }

    public function getNews(Request $request)
    {
        $page = $request->page;
        $news = News::orderBy('created_at', 'desc')->offset($page*5)->limit(6);
        $request->text ? $news = $news->where('title', 'LIKE', "%".$request->text."%")
                                    ->orWhere('description', 'LIKE', "%".$request->text."%")->get()
                        : $news = $news->get();
        count($news) <= 5 ? $end = true : $end = false;
        $news = $news->take(5);
        $data = view('admin.news.ajax.get_news', compact('news'))->render();
        return response()->json(['data'=>$data, 'end'=>$end]);
    }

    public function delete(Request $request)
    {
        $news = News::findOrFail($request->id);
        Storage::disk('public')->delete($news->img);
        $news->delete();
        return response()->json(['success'=>true]);
    }

    public function edit(Request $request)
    {
        $news = News::findOrFail($request->id);
        return response()->json(['data'=>$news]);
    }

    public function update(Request $request)
    {

        $news = News::findOrFail($request->id);
        if(!empty($request->img)) {
            Storage::disk('public')->delete($news->img);
            $img = $request->file('img')->store('news_images', 'public');
            $news->img = $img;
        }
        $news->title = $request->title;
        $news->description = $request->description;
        $news->text = $request->text;
        $news->save();
        return response()->json($request);
    }
}
