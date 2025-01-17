<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class FiddleController extends Controller{

    public function one(){
        $countPosts = Blogpost::count();
        $countFeaturedPosts = Blogpost::where('featured', '=', 1) -> count();
        $countComment = Comment::count();

        dump($countPosts);
        dump($countFeaturedPosts);
        dump($countComment);
    }

    public function two(){
        $postOne = Blogpost::findOrFail(1);

        dump($postOne);
    }

    public function three(){
        //$postOneTitle = Blogpost::all('title', 'id')->where('id', '=', 1);
        $postOneTitle = Blogpost::findOrFail(1)->value('title');

        dump($postOneTitle);
    }

    public function four(){
        $postOneAuthorName = Blogpost::findOrFail(1)->author()->value('first_name');

        dump($postOneAuthorName);
    }

    public function five(){
        $postOneCategory = Blogpost::findOrFail(1)->category()->value('title');

        dump($postOneCategory);
    }

    public function six(){
        $postsWithA = Blogpost::where('title', 'like', 'A%')->orderBy('created_at','desc')->get();

        dump($postsWithA);
    }

    public function seven(){
        $categories = Category::all();
        $categoriesArray = $categories->mapWithKeys(function ($categorie){
            return [$categorie['id'] => $categorie['title']];
        });

        dump($categoriesArray);
    }

    public function eight(){
        $commentJoris = Author::where('first_name', 'like', 'Joris')->first()->comments()->get();
        /*
        $authorId = Author::where('first_name', 'like', 'Joris')->value('id');
        $commentJoris = Comment::where('id', $authorId)->get();
        */
        /*
        $commentJoris = Author::where('first_name', 'Joris')
            ->join('comments', 'authors.id', '=', 'comments.author_id')
            ->select('comments.*')
            ->get();
        */

        dump($commentJoris);
    }

    public function nine(){
        $blogposts = Blogpost::leftJoin('comments', 'blogposts.id', '=', 'comments.blogpost_id')
            ->select('blogposts.*')
            ->whereNull('comments.blogpost_id')
            ->get();
        dump($blogposts);
    }

    public function ten(){
        $newAuthor = Author::create(['first_name' => 'Siebe', 'last_name' => 'Van de Voorde', 'email' => 'test@test.com', 'website' => 'test.com', 'location' => 'gent']);
        $newAuthor->save();
    }

    public function eleven(){
        $author = Author::find(11);
        $blogpost = Blogpost::find(1);
        $comment = new Comment;
        $comment->content = 'some text is written here';
        $comment->blogpost()->associate($blogpost);
        $comment->author()->associate($author);
        $comment->save();
    }

    public function test($id){
        DB::enableQueryLog();
        $callback = function ($query) use ($id){
            $query->where('blogpost_id', '=', $id);
        };
        $tags = Tag::query();
        $tags->whereHas('blogposts',$callback)->with(['blogposts'=>$callback]);
        $tags = $tags->pluck('tags.id')->all();
        dump($tags);
        $blogpost = Blogpost::with('tags')->findOrFail($id);
        for($i = 0; $i<sizeof($tags); $i++){
            $blogpost->tags()->detach($tags[$i]);
        }
        $blogpost->destroy($id);
        dump($blogpost);
        dump(DB::getQueryLog());
        dd('test');
    }

}
