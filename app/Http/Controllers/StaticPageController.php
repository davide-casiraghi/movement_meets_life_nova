<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\Snippets\GalleryMasonryService;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    private GalleryMasonryService $galleryMasonryService;

    public function __construct(
        GalleryMasonryService $galleryMasonryService,
    ) {
        $this->galleryMasonryService = $galleryMasonryService;
    }

    /**
     * Show the treatments page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function treatments()
    {
        return view('pages.treatments');
    }

    /**
     * Show the Contact Improvisation page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactImprovisation()
    {
        $post = Post::firstOrCreate([
            'title->en' => 'Static pages images',
            'intro_text->en' => 'Static pages images',
            'body->en' => 'Static pages images',
            'category_id' => 1,
            'user_id' => 1,
        ]);
        $post->setStatus('published');

        $animate = true;
        $gallery1Images = $this->galleryMasonryService->createImagesArray($post, 'cippo');
        $gallery1Html = $this->galleryMasonryService->prepareGalleryHtml($gallery1Images, $animate);

        return view('pages.contactImprovisation', [
            'gallery1Html' => $gallery1Html,
        ]);
    }
}
