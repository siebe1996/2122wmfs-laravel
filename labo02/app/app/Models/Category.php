<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected  $fillable = ['title'];
    //protected $hidden = ['id'];

    public function blogposts(){
        return $this->hasMany(Blogpost::class);
    }
}
