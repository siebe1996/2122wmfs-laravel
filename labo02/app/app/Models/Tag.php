<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    //protected $hidden = ['id'];

    public function blogposts(){
        return $this->belongsToMany(Blogpost::class);
    }

    public function setTitleAttribute($value) {
        $this->attributes['title'] = strtolower($value);
    }
}
