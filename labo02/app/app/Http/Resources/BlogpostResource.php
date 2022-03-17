<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogpostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        /*return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'brand' => new BrandResource($this->brand),
            'categories' => CategoryResource::collection($this->categories),
        ];*/
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'featured' => $this->featured,
            'category' => new CategoryResource($this -> category),
            'author' => new AuthorResource($this -> author),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments' => new CommentCollection($this->comments),
            'tags' => new TagCollection($this->tags)
        ];
    }
}
