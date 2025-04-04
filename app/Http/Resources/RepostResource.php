<?php

namespace App\Http\Resources;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RepostResource extends JsonResource
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
            'id_user' => User::where('id', $this->id_user)->get(),
            'id_repost_user' => User::where('id', $this->id_repost_user)->get(),
            'id_post' => AllPostsResource::collection(Post::where('id', $this->id_post)->get()),
            'created_at' => $this->created_at
        ];
    }
}
