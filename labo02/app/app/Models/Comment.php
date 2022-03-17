<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'blogpost_id', 'author_id', 'updated_at'];
    //protected $hidden = ['id', 'created_at'];

    public function blogpost(){
        return $this->belongsTo(Blogpost::class);
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }
}
