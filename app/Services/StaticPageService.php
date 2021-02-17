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
     * Return the static gallery HTML
     *
     * To show this in a blade view:
     * - Load in the controller method end pass it to the view:
     *      $gallery1Html = $this->staticPageService->getStaticGalleryHtml('contact improvisation', true);
     * - Then in the blade view:
     *      {!! $gallery1Html !!}
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

        if (empty($galleryImages)) {
            return "<div class='bg-yellow-200 p-5'>There is not a gallery called <b>$galleryName</b>. <br> Please define it in the Media manager</div>";
        }

        return $this->galleryMasonryService->prepareGalleryHtml($galleryImages, $animate);
    }


}
