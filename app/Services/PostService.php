<?php
namespace App\Services;

use App\Services\Snippets\Accordion;
use App\Services\Snippets\GalleryMasonry;

class PostService {
    private $accordion;
    private $gallery;

    public function __construct(Accordion $accordion, GalleryMasonry $gallery) {
        $this->accordion = $accordion;
        $this->gallery = $gallery;
    }

    public function getPostBody($post){
        $postBody = $post->body;

        $postBody = $this->accordion->snippetsToHTML($postBody);
        $postBody = $this->gallery->snippetsToHTML($postBody);

        return $postBody;
    }
}