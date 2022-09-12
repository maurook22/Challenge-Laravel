<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{

    public function top()
    {

        return Post::select(
            'posts.id',
            'posts.body',
            'posts.title',
            DB::raw('MAX(rating) as rating'),
            'users.name',
            'users.id as user_id'
        )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->groupby('posts.user_id')
            ->get();
    }

    public function get($id)
    {

        return Post::select(
            'posts.id',
            'posts.body',
            'posts.title',
            'users.name'
        )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.id', '=', $id)
            ->get();
    }
}
