<?php

namespace App\Services;

use App\Models\Post;
use App\Services\Snippets\GalleryMasonryService;

class StaticPageService
{
    private GalleryMasonryService $galleryMasonryService;

    /**
     * StaticPageService constructor.
     *
     * @param \App\Services\Snippets\GalleryMasonryService $galleryMasonryService
     */
    public function __construct(
        GalleryMasonryService $galleryMasonryService
    ) {
        $this->galleryMasonryService = $galleryMasonryService;
    }

    /**
     * Return the static gallery hrml
     *
     * @param string $galleryName
     * @param bool $animate
     *
     * @return string
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function getStaticGalleryHtml(string $galleryName, bool $animate): string
    {
        $post = Post::firstOrCreate([
            'title->en' => 'Static pages images',
            'intro_text->en' => 'Static pages images',
            'body->en' => 'Static pages images',
            'category_id' => 1,
            'user_id' => 1,
        ]);
        $post->setStatus('published');

        $galleryImages = $this->galleryMasonryService->createImagesArray($post, $galleryName);
        $galleryHtml = $this->galleryMasonryService->prepareGalleryHtml($galleryImages, $animate);

        return $galleryHtml;
    }


}
