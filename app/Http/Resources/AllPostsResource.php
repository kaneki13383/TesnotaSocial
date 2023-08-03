<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Models\PhotoPost;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AllPostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'id_user' => User::find($this->id_user),
            'text' => $this->text,
            'photos' => PhotoPost::where('id_post', $this->id)->get(),
            'likes' => $this->likes,
            'created_at' => $this->created_at
        ];
    }
}
