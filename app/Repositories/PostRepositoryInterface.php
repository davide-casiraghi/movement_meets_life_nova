<?php

namespace App\Repositories;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;

interface PostRepositoryInterface {

    /**
     * Get all Posts.
     *
     * @return iterable
     */
    public function getAll();

    /**
     * Get Post by id
     *
     * @param $postId
     *
     * @return Post
     */
    public function getById($postId);

    /**
     * Store Alert
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     *
     * @return Alert
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(PostStoreRequest $data);

    /**
     * Update Alert
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     * @param int $id
     *
     * @return Post
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(PostStoreRequest $data, int $id);

    /**
     * Delete Post
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id);

}