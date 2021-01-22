<?php

namespace App\Repositories;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{

    /**
     * Get all Posts.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Post::orderBy('created_at', 'desc');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where(
                    'title',
                    'like',
                    '%' . $searchParameters['title'] . '%'
                );
            }
            if (!empty($searchParameters['categoryId'])) {
                $query->where('category_id', $searchParameters['categoryId']);
            }
            if (!empty($searchParameters['startDate'])) {
                $startDate = Carbon::createFromFormat(
                    'd/m/Y',
                    $searchParameters['startDate']
                );
                $query->where('created_at', '>=', $startDate);
            }
            if (!empty($searchParameters['endDate'])) {
                $endDate = Carbon::createFromFormat(
                    'd/m/Y',
                    $searchParameters['endDate']
                );
                $query->where('created_at', '<=', $endDate);
            }
            if (!empty($searchParameters['status'])) {
                $query->currentStatus($searchParameters['status']);
            }
        }

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage);
        } else {
            $results = $query->get();
        }

        return $results;
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

        $post->setStatus('published');

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

        $status = ($data['status'] == 'on') ? 'published' : 'unpublished';
        if ($post->publishingStatus() != $status) {
            $post->setStatus($status);
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
