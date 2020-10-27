<?php
namespace App\Services;

use App\Services\Snippets\AccordionService;
use App\Services\Snippets\GalleryMasonryService;

class PostService {
    private $accordionService;
    private $galleryService;
    private $glossaryService;

    public function __construct(AccordionService $accordionService, GalleryMasonryService $galleryService, GlossaryService $glossaryService) {
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
}