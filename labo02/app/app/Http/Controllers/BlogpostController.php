<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogpostCollection;
use App\Http\Resources\BlogpostResource;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogpostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogposts = new BlogpostCollection(Blogpost::all());
        return response(['data' => $blogposts], 200)
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
            'title' => 'required|unique:blogposts|max:125',
            'content' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'image' => 'image|mimes:jpeg,png'
        ]);
        $path = '';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public');
        }
        if ($request->featured == null){
            $request['featured'] = '0';
        }
        if ($request->tags !== null){
            $requestTagArray = explode(" ",strtolower($request->tags));
            $databaseTagArray = Tag::pluck('title')->toArray();
            foreach ($requestTagArray as $requestTag){
                if(!in_array($requestTag, $databaseTagArray)){
                    $tag = new Tag;
                    $tag->title = $requestTag;
                    $tag->save();
                }
            }
            $tagIds = Tag::whereIn('title',$requestTagArray)->pluck('id')->toArray();
        }
        $author = Author::findOrFail($request->author_id);
        $category = Category::findOrFail($request->category_id);
        $blogpost = new Blogpost;
        $blogpost->title = $request->title;
        $blogpost->content = $request->input('content');
        $blogpost->featured = $request->featured;
        $blogpost->image = substr($path,7);
        $blogpost->category()->associate($category);
        $blogpost->author()->associate($author);
        $blogpost->save();
        if ($request->tags !== null){
            $blogpost->tags()->attach($tagIds);
        }
        $blogpost = new BlogpostResource($blogpost);
        return response(['data' => $blogpost], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return //\Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogpost = new BlogpostResource(Blogpost::with('category','author','tags')->findOrFail($id));
        return response(['data' => $blogpost], 200)
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
        $blogpost = Blogpost::with('category','author','tags')->findOrFail($id);
        if ($request->tags !== null){
            $requestTagArray = explode(" ",strtolower($request->tags));
            $databaseTagArray = Tag::pluck('title')->toArray();
            foreach ($requestTagArray as $requestTag){
                if(!in_array($requestTag, $databaseTagArray)){
                    $tag = new Tag;
                    $tag->title = $requestTag;
                    $tag->save();
                }
            }
            $tagIds = Tag::whereIn('title',$requestTagArray)->pluck('id')->toArray();
        }
        if ($request->tags !== null){
            $blogpost->tags()->sync($tagIds);
        }
        $blogpost->update($request->all());
        $blogpost = new BlogpostResource($blogpost);
        return response(['data' => $blogpost], 200)
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
        $callback = function ($query) use ($id){
            $query->where('blogpost_id', '=', $id);
        };
        $tags = Tag::query();
        $tags->whereHas('blogposts',$callback)->with(['blogposts'=>$callback]);
        $tags = $tags->pluck('tags.id')->all();
        $blogpost = Blogpost::with('tags')->findOrFail($id);
        for($i = 0; $i<sizeof($tags); $i++){
            $blogpost->tags()->detach($tags[$i]);
        }
        $blogpost->destroy($id);
        $comments = Comment::where('blogpost_id', $id);
        foreach ($comments as $comment){
            $comment->delete();
        }
        $blogpost = new BlogpostResource($blogpost);
        return response(['data' => $blogpost], 200)
            ->header('Content-Type', 'application/json');
    }
}
