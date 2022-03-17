<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'website', 'location', 'updated_at'];
    //protected $hidden = ['id', 'created_at'];

    public function blogposts(){
        return $this->hasMany(Blogpost::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
}
