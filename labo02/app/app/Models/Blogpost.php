<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image', 'featured', 'updated_at'];
    protected $hidden = ['id', 'author_id', 'category_id', 'created_at'];
    protected $attributes = ['featured' => 0];

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
