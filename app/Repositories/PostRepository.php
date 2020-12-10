<?php


namespace App\Repositories;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostRepository implements PostRepositoryInterface {

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

    /**
     * Store Post
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     *
     * @return Post
     */
    public function store(PostStoreRequest $data)
    {
        $post = new Post();

        $post->title = $data['title'] ?? null;
        $post->category_id = $data['category_id'] ?? null;
        $post->created_by = Auth::id();
        $post->intro_text = $data['intro_text'] ?? null;

        $post->body = $data['body'] ?? null;
        $post->before_content = $data['before_content'] ?? null;
        $post->after_content = $data['after_content'] ?? null;

        $post->featured = $data['featured'] ?? 0;
        $post->publish_at = $data['publish_at'] ?? null;
        $post->publish_until = $data['publish_until'] ?? null;

        $post->save();

        //$alert->setStatus(($data['send_as_sms'] == 'on') ? 'approved' : 'pending');

        return $post->fresh();
    }

    /**
     * Update Post
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     * @param int $id
     *
     * @return Post
     */
    public function update(PostStoreRequest $data, int $id)
    {
        $post = $this->getById($id);

        $post->title = $data['title'] ?? null;
        $post->category_id = $data['category_id'] ?? null;
        $post->intro_text = $data['intro_text'] ?? null;

        $post->body = $data['body'] ?? null;
        $post->before_content = $data['before_content'] ?? null;
        $post->after_content = $data['after_content'] ?? null;

        $post->featured = $data['featured'] ?? 0;
        $post->publish_at = $data['publish_at'] ?? null;
        $post->publish_until = $data['publish_until'] ?? null;

        $post->update();

        if($post->wasChanged()){
            $post->setStatus('updated', Auth::id());
        }

        return $post;
    }

    /**
     * Delete Post
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Post::destroy($id);
    }
}