<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $news = News::all();
        return response()->json([
            'message' => 'Get All Resource',
            'data' => $news
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'content' => 'required',
            'url' => 'required|url',
            'published_at' => 'required|date',
            'category' => 'required',
        ]);

        $news = News::create($request->all());

        return response()->json([
            'message' => 'Resource is added seccessfully',
            'data' => $news
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $news = News::find($id);
        if ($news) {
            return response()->json(['message' => 'Get detail resource', 'data' => $news], 200);
        }
        return response()->json(['message' => 'resource not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);
        if ($news) {
            $news->update($request->all());
            return response()->json(['message' => 'Resource is updated seccessfully', 'data' => $news], 200);
        }
        return response()->json(['message' => 'resource not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, News $news)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $news = News::find($id);
        if ($news) {
            $news->delete();
            return response()->json(['message', 'Resource is deleted successfully'], 200);
        }
        return response()->json(['message' => 'Resource not found'], 404);
    }

    public function search($title)
    {
        $news = News::where('title', 'like', "%$title%")->get();
        return $news->isEmpty() ?
            response()->json(['message' => 'Resource not found'], 404) :
            response()->json(['message' => 'Get searched resource', 'data' => $news], 200);
    }
}

