<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Blogpost_Tag;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class BlogController extends Controller{

    public function home(){
        $categories = Category::all();
        //$featuredBlogposts = Blogpost::where('featured', '=', 1)->get();
       /*$featuredBlogposts = Blogpost::where('featured', '=', 1)
            ->join('categories', 'blogposts.category_id', '=', 'categories.id')
            ->select('categories.title as categoryTitle', 'blogposts.*')
            ->get();
       */
       $featuredBlogposts = Blogpost::with('category')
            ->get();
        /*foreach ($featuredBlogposts as $post) {
            dump($post->category->title);
        }*/
        //dd($featuredBlogposts);
        return view('homepage', ['featuredBlogposts' => $featuredBlogposts, 'term' => '', 'categories' => $categories]);
    }

    public function add(){
        $recentBlogposts = Blogpost::orderBy('created_at','desc')->limit(10)->get();
        $categories = Category::all();
        $authors = Author::all();
        //dd($categories);
        return view('add-with-tags', ['recentBlogposts' => $recentBlogposts, 'categories' => $categories, 'authors' => $authors]);
    }

    public function category(String $category){
        $recentBlogposts = Blogpost::orderBy('created_at','desc')->limit(10)->get();
        $categories = Category::all();
        /*$categoryBlogposts = Category::where('title','like',$category)->first()->blogposts()
            ->join('authors', 'blogposts.author_id', '=', 'authors.id')
            ->select('authors.first_name', 'authors.last_name', 'authors.id as authorId', 'blogposts.*') -> get();
        */
        $categoryBlogposts = Category::where('title','like',$category)->first()->blogposts()->with('author')->get();
        //dd($categoryBlogposts);
        return view('category', ['categoryBlogposts' => $categoryBlogposts, 'category' => $category, 'recentBlogposts' => $recentBlogposts, 'categories' => $categories]);
    }

    public function blogpost(int $id){
        $recentBlogposts = Blogpost::orderBy('created_at','desc')->limit(10)->get();
        $categories = Category::all();
        /*$idBlogpost = Blogpost::where('blogposts.id', $id)->join('authors', 'blogposts.author_id', '=', 'authors.id')
            ->select('authors.first_name', 'authors.last_name', 'authors.id as authorId', 'blogposts.*')->get();
        $commentsIdBlogpost = Comment::where('comments.blogpost_id', $id)->join('authors', 'comments.author_id', '=', 'authors.id')
            ->select('authors.first_name', 'authors.last_name', 'authors.id as authorId', 'comments.*')->get();*/
        //dd($idBlogpost, $commentsIdBlogpost);
        $idBlogpost = Blogpost::where('blogposts.id', $id)->with('author')->get();
        $commentsIdBlogpost = Comment::where('comments.blogpost_id', $id)->with('author')->get();
        return view('blogpost', ['idBlogpost' => $idBlogpost, 'commentsIdBlogpost' => $commentsIdBlogpost, 'recentBlogposts' => $recentBlogposts, 'categories' => $categories]);
    }

    public function author(int $id){
        $recentBlogposts = Blogpost::orderBy('created_at','desc')->limit(10)->get();
        $categories = Category::all();
        $author = Author::where('id', $id)->get();
        $authorBlogposts = Blogpost::where('blogposts.author_id', $id)->get();
        //dd($author);
        return view('author', ['authorBlogposts' => $authorBlogposts, 'author' => $author, 'recentBlogposts' => $recentBlogposts, 'categories' => $categories]);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|unique:blogposts|max:125',
            'content' => 'required',
            'category_id' => 'required',
            'author_id' => 'required',
            'image' => 'image|mimes:jpeg,png|required'
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
            //dd($tagIds);
        }
        return redirect('/');
    }

}
