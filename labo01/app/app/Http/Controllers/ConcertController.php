<?php

namespace App\Http\Controllers;

use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;

class ConcertController extends Controller{

    public  function overview(Request $request){
        $term = strval($request->query('search'));
        //dd($term);
        if($term){
            return redirect('/search/'.$term);
        }
        else{
            $concerts = DB::select('select * from concerts');
            return view('index', ['concerts' => $concerts, 'term' => '']);
        }

        //return view('index-start', ['concerts' => Concerts::all()]);
    }

    public function home(){
        return redirect('/concerts');
    }

    public function search(String $term){
        $foundConcerts = DB::select('select * from concerts where title like ?', ['%'.$term.'%']);
        return view('index', ['concerts' => $foundConcerts, 'term' => $term]);
    }

    public function changeLike(int $id){
        $update = DB::update('update concerts set fav = !fav where id = ?', [$id]);
        return redirect('/');
    }

    public function concert(int $id){
        $concert = DB::select('select * from concerts where id = ?', [$id]);
        $images = DB::select('select * from images where concert_id = ?', [$id]);
        if (empty($concert)){
            return view('404');
        }
        return view('concert', ['concert' => $concert, 'images' => $images]);
    }

    public function images(int $id, int $imgId){
        $concertId = DB::select('select concert_id from images where id = ?', [$imgId]);
        $concert = DB::select('select * from concerts where id = ?', [$concertId[0]->concert_id]);
        $img = DB::select('select * from images where id = ?', [$imgId]);
        return view('concert-image', ['img' => $img, 'concert' => $concert]);
    }

    public function notfound()
    {
        return view('404');
    }

    public function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

}
