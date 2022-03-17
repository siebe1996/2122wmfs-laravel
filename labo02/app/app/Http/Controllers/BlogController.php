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

    public function search(Request $request){

        $callback = function ($query) use ($request){
            $query->where('tags.title', 'like', "%{$request->tags}%");
        };

        DB::enableQueryLog();
        dump($request);
        $categories = Category::all();
        $authors = Author::all();
        $blogposts = Blogpost::query();
        $blogposts->with('category');
        $blogposts->when($request->filled('term'), function ($query) use ($request){
            $requestTermArray = explode(" ",strtolower($request->term));
            foreach ($requestTermArray as $requestTerm){
                $query->where('blogposts.title', 'like', "%{$requestTerm}%");
            }
            return $query;
        });
        /*
        $blogposts->when($request->filled('tags'), function ($query) use ($request, $callback){
            $query->whereHas('tags', $callback)->with(['tags'=>$callback]);
        });*/
        $blogposts->when($request->filled('tags'), function ($query) use ($request){
            $requestTagsArray = explode(" ",strtolower($request->tags));
            $requestTagsItem = $requestTagsArray[0];
            $query->whereHas('tags', function ($query) use ($requestTagsItem){
                $query->where('tags.title', 'like', "%{$requestTagsItem}%");
            })->with(['tags'=> function ($query) use ($requestTagsItem) {
                $query->where('tags.title', 'like', "%{$requestTagsItem}%");
            }]);
            if (sizeof($requestTagsArray) > 1){
                for($i = 1; $i < sizeof($requestTagsArray); $i++){
                    $requestTagsItem = $requestTagsArray[$i];
                    $query->orWhereHas('tags', function ($query) use ($requestTagsItem){
                        $query->where('tags.title', 'like', "%{$requestTagsItem}%");
                    })->with(['tags'=> function ($query) use ($requestTagsItem) {
                        $query->where('tags.title', 'like', "%{$requestTagsItem}%");
                    }]);
                }
            }
            return $query;
        });
        $blogposts->when($request->filled('category_id'), function ($query) use ($request){
            return $query->where('blogposts.category_id', $request->category_id);
        });
        $blogposts->when($request->filled('author_id'), function ($query) use ($request){
            return $query->where('blogposts.author_id', $request->author_id);
        });
        if ($request->filled('after')||$request->filled('before')){
            if ($request->filled('after') && $request->filled('before')){
                $blogposts->whereBetween('blogposts.created_at', [$request->after, $request->before]);
            }
            elseif ($request->filled('after')){
                $blogposts->where('blogposts.created_at', '>', $request->after);
            }
            else{
                $blogposts->where('blogposts.created_at', '<', $request->before);
            }
        }
        $blogposts->when($request->filled('sort'), function ($query) use ($request){
            if($request->sort === 'most_recent'){
                return $query->orderBy('blogposts.created_at', 'DESC');
            }
            elseif($request->sort === 'less_recent'){
                return $query->orderBy('blogposts.created_at', 'ASC');
            }
            else{
                return $query->orderBy('blogposts.title');
            }
        });
        $blogposts = $blogposts->paginate(15)->withQueryString();
        dump(DB::getQueryLog());
        dump($blogposts);
        dump(session());
        $sortArray = ['most_recent' => 'most recent', 'less_recent' => 'less recent', 'title' => 'title'];
        return view('search', ['categories' => $categories, 'authors' => $authors, 'blogposts' => $blogposts, 'sortArray' => $sortArray]);
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
        return redirect('blogposts/'.$blogpost->id);
    }

}
