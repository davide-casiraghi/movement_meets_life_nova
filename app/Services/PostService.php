<?php
namespace App\Services;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Services\Snippets\AccordionService;
use App\Services\Snippets\GalleryMasonryService;

class PostService {
    private $postRepository;
    private $accordionService;
    private $galleryService;
    private $glossaryService;

    public function __construct(
        PostRepository $postRepository,
        AccordionService $accordionService,
        GalleryMasonryService $galleryService,
        GlossaryService $glossaryService
    ) {
        $this->postRepository = $postRepository;
        $this->accordionService = $accordionService;
        $this->galleryService = $galleryService;
        $this->glossaryService = $glossaryService;
    }

    public function getPostBody($post){
        $postBody = $post->body;

        $postBody = $this->accordionService->snippetsToHTML($postBody);
        $postBody = $this->galleryService->snippetsToHTML($postBody);
        $postBody = $this->glossaryService->markGlossaryTerms($postBody);

        return $postBody;
    }

    /**
     * Create a post
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     *
     * @return \App\Models\Post
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createPost(PostStoreRequest $data)
    {
        $post = $this->postRepository->store($data);

        $post->setStatus('pending');

        $this->storeImages($post, $data);

        return $post;
    }

    /**
     * Update the Post
     *
     * @param \App\Http\Requests\PostStoreRequest $data
     * @param int $postId
     *
     * @return \App\Models\Post
     */
    public function updatePost(PostStoreRequest $data, int $postId)
    {
        $post = $this->postRepository->update($data, $postId);

        $this->storeImages($post, $data);

        return $post;
    }

    /**
     * Return the post from the database
     *
     * @param $postId
     *
     * @return \App\Models\Post
     */
    public function getById(int $postId)
    {
        return $this->postRepository->getById($postId);
    }

    /**
     * Get all the Posts.
     *
     * @return iterable
     */
    public function getPosts(int $recordsPerPage = null)
    {
        return $this->postRepository->getAll($recordsPerPage);
    }

    /**
     * Delete the post from the database
     *
     * @param int $postId
     */
    public function deletePost(int $postId): void
    {
        $this->postRepository->delete($postId);
    }

    /**
     * Get the number of post created in the last 30 days.
     *
     * @return int
     */
    public function getNumberPostsCreatedLastThirtyDays()
    {
        return Post::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Store the uploaded photos in the Spatie Media Library
     *
     * @param \App\Models\Post $post
     * @param \App\Http\Requests\PostStoreRequest $data
     *
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function storeImages(Post $post, PostStoreRequest $data):void {
        /*if($data->file('photos')) {
            foreach ($data->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $post->addMedia($photo)->toMediaCollection('post');
                }
            }
        }*/

        if($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $post->addMedia($introimage)->toMediaCollection('posts');
            }
        }
    }

    /**
     * Return an array with the thumb images ulrs
     *
     * @param int $postId
     *
     * @return array
     */
    public function getThumbsUrls(int $postId): array{
        $thumbUrls = [];

        $post = $this->getById($postId);
        foreach($post->getMedia('post') as $photo){
            $thumbUrls[] = $photo->getUrl('thumb');
        }

        return $thumbUrls;
    }

}