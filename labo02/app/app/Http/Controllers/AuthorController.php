<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = new AuthorCollection(Author::all());
        return response(['data' => $authors], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:125',
            'last_name' => 'required|max:125',
            'email' => 'required|email:rfc,dns',
            'website' => 'required|max:125',
            'location' => 'required|max:125'
        ]);

        $author = new Author;
        $author->first_name = $request->first_name;
        $author->last_name = $request->last_name;
        $author->email = $request->email;
        $author->website = $request->website;
        $author->location = $request->location;
        $author->save();
        $author = new AuthorResource($author);
        return response(['data' => $author], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = new AuthorResource(Author::findOrFail($id));
        return response(['data' => $author], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|max:125',
            'last_name' => 'required|max:125',
            'email' => 'required|email:rfc,dns',
            'website' => 'required|max:125',
            'location' => 'required|max:125'
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->all());
        $author = new AuthorResource($author);
        return response(['data' => $author], 200)
            ->header('Content-Type', 'application/json');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $author = Author::destroy($id);
        $author = new AuthorResource($author);
        return response(['data' => $author], 200)
            ->header('Content-Type', 'application/json');
    }
}
