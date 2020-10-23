<?php

namespace App\Services\Snippets;

/*
    This class show a responsive accordion with a title that open when [+] button is clicked.
    Example of snippet:
    {slider=HOW to add contents to this website? - Create account} lorem ipsum {/slider}
*/

class Accordion {

    /**
     * Substitute accordion snippets with the related HTML
     *
     * @return iterable
     */
    public function snippetsToHTML($postBody)
    {
        $count = 0;

        // Load the accordion template
        $sliderTemplate = "<div class='w-full'>";
        $sliderTemplate .= "<input type='checkbox' name='panel' id='panel-1' class='hidden'>";
            $sliderTemplate .= "<label for='panel-1' class='relative block bg-black text-white p-4 shadow border-b border-grey'>{SLIDER_TITLE}</label>";
            $sliderTemplate .= "<div class='accordion__content overflow-hidden bg-grey-lighter'>";
                $sliderTemplate .= "<h2 class='accordion__header pt-4 pl-4'>Header</h2>";
                $sliderTemplate .= "<p class='accordion__body p-4' id='panel1'>{SLIDER_CONTENT}</p>";
            $sliderTemplate .= "</div>";
        $sliderTemplate .= "</div>";

        // Do the replacement if needed
        if (substr_count($postBody, '{slide') > 0) {

            /*
             * If the post is not wrapped yet with 'textHasAccordion accordion', wrap it.
             (first accordion found in the page)
            */
            if (strpos($postBody, 'textHasAccordion') == false) {
                $postBody = '<div class="textHasAccordion accordion">'.$postBody.'</div>';
            }

            $regex = "#(?:<p>)?\{slide[r]?=([^}]+)\}(?:</p>)?(.*?)(?:<p>)?\{/slide[r]?\}(?:</p>)?#s";

            $postBody = preg_replace(
                $regex,
                str_replace(
                    ['{SLIDER_TITLE}', '{SLIDER_CONTENT}'],
                    ['$1', '$2', '$3'],
                    $sliderTemplate,
                ),
                $postBody
            );
        }
        return $postBody;
    }



    function rep_count($matches) {
        global $count;
        return 'test' . $count++;
    }
}