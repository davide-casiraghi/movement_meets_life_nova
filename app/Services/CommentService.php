<?php


namespace App\Services;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;

class CommentService {

    /**
     * Create a comment
     *
     * @param \App\Http\Requests\CommentStoreRequest $data
     *
     * @param mixed $entity
     *
     * @return \App\Models\Comment
     */
    public function createComment(CommentStoreRequest $data, $entity)
    {
        $comment = new Comment;
        $comment->body = $data['body'];
        $comment->name = $data['name'];
        $comment->email = $data['email'];

        $entity->comments()->save($comment);

        return $comment;
    }
}