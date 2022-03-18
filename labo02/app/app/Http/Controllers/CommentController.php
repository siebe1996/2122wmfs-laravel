<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = new CommentCollection(Comment::all());
        return response(['data' => $comments], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:125',
            'blogpost_id' => 'required|max:125'
        ]);

        $comment = new Comment;
        $comment->content = $request->input('content');
        $comment->blogpost_id = $request->blogpost_id;
        $comment->save();
        $comment = new CommentResource($comment);
        return response(['data' => $comment], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = new CommentResource(Comment::findOrFail($id));
        return response(['data' => $comment], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:125',
            'blogpost_id' => 'required|max:125'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());
        $comment = new CommentResource($comment);
        return response(['data' => $comment], 200)
            ->header('Content-Type', 'application/json');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->destroy($id);
        $comment = new CommentResource($comment);
        return response(['data' => $comment], 200)
            ->header('Content-Type', 'application/json');
    }
}
