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
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(PostStoreRequest $data)
    {
        $post = new Post();

        $post->name = $data['name'] ?? null;
        $post->email = $data['email'] ?? null;
        $post->phone = $data['phone'] ?? null;
        $post->short_description = $data['short_description'] ?? null;
        $post->long_description = $data['long_description'] ?? null;

        $post->send_as_sms =  ($data['send_as_sms'] == 'on') ? 1 : 0;
        $post->send_as_email =  ($data['send_as_email'] == 'on') ? 1 : 0;
        $post->show_on_website =  ($data['show_on_website'] == 'on') ? 1 : 0;

        $post->report_id = $data['report_id'] ?? null;
        $post->region_id = $data['region_id'] ?? null;

        $post->author_id = Auth::id();
        $post->approver_id = $data['approver'] ?? null;

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
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(PostStoreRequest $data, int $id)
    {
        $post = $this->getById($id);

        $post->name = $data['name'] ?? null;
        $post->email = $data['email'] ?? null;
        $post->phone = $data['phone'] ?? null;
        $post->short_description = $data['short_description'] ?? null;
        $post->long_description = $data['long_description'] ?? null;

        $post->sent_on = $data['sent_on'] ?? null;
        $post->send_as_sms =  ($data['send_as_sms'] == 'on') ? 1 : 0;
        $post->send_as_email =  ($data['send_as_email'] == 'on') ? 1 : 0;
        $post->show_on_website =  ($data['show_on_website'] == 'on') ? 1 : 0;

        $post->report_id = $data['report_id'] ?? null;
        $post->region_id = $data['region_id'] ?? null;

        $post->approver_id = $data['approver'] ?? null;

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