<?php


namespace App\Repositories;

use App\Models\Post;


class PostRepository {

    /**
     * Get all Posts.
     *
     * @return iterable
     */
    public function getAll()
    {
        return Post::all();
    }

    /**
     * Get Post by id
     *
     * @param $postId
     * @return Post
     */
    public function getById($postId)
    {
        return Post::findOrFail($postId);
    }


}