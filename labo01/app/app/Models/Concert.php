<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model{
    use HasFactory;

    protected  $fillable = ['title', 'location', 'price', 'fav', 'start_date'];

}
