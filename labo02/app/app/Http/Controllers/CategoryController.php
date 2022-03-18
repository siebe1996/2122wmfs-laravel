<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = new CategoryCollection(Category::all());
        return response(['data' => $categories], 200)
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
            'title' => 'required|unique:blogposts|max:125'
        ]);

        $category = new Category;
        $category->title = $request->title;
        $category->save();
        $category = new CategoryResource($category);
        return response(['data' => $category], 200)
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
        $category = new CategoryResource(Category::findOrFail($id));
        return response(['data' => $category], 200)
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
            'title' => 'required|unique:blogposts|max:125'
        ]);
        $category = Category::findOrFail($id);
        $category->update($request->all());
        $category = new CategoryResource($category);
        return response(['data' => $category], 200)
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
        $category = Category::findOrFail($id);
        $category->destroy($id);
        $category = new CategoryResource($category);
        return response(['data' => $category], 200)
            ->header('Content-Type', 'application/json');
    }
}
