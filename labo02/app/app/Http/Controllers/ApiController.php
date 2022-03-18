<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogpostCollection;
use App\Http\Resources\BlogpostResource;
use App\Models\Author;
use App\Models\Blogpost;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends Controller
{
    public function blogposts(){
        $blogposts = new BlogpostCollection(Blogpost::with('category','author','tags')->get());
        return ['data' => $blogposts];
    }

    public function singleBlogpost($id){
        $blogpost = Blogpost::with('category','author','tags')->findOrFail($id);
        return new BlogpostResource($blogpost);
    }
}
