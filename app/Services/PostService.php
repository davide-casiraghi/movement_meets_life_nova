<?php


namespace App\Services;


use App\Services\Contents\Accordion;

class PostService {
    private $accordion;

    public function __construct(Accordion $accordion) {
        $this->accordion = $accordion;
    }

    public function getPostBody($post){
        $postBody = $post->body;

        $postBody = $this->accordion->substituteAccordionSnippets($postBody);


        return $postBody;
    }
}