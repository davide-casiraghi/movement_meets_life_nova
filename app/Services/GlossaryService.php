<?php
namespace App\Services;

use App\Models\Glossary;


class GlossaryService {

    /**
     * Finds the matches of all the words of the glossary in the specified text
     *
     * @return string
     */
    public function markGlossaryTerms($text)
    {
        $glossaryTerms = Glossary::where('is_published', 1)->get();

        foreach ($glossaryTerms as $id => $glossaryTerm){
            $text = $this->replaceGlossaryTerm($glossaryTerm, $text);
            $text = $this->attachTermDescription($glossaryTerm, $text);
        }

        return $text;
    }

    /**
     * Replace glossary term
     *
     * @return string
     */
    private function replaceGlossaryTerm(Glossary $glossaryTerm, string $text) {
        $pattern = "/\b$glossaryTerm->term\b/";
        $text = preg_replace_callback(
            $pattern,
            function($matches) use ($glossaryTerm){
                $glossaryTermTemplate = "<a href='/glossaryTerms/".$glossaryTerm->id."' class='text-red-700'>".$glossaryTerm->term."</a>";
                return $glossaryTermTemplate;
            },
            $text);

        return $text;
    }

    /**
     * Attach the term tooltip content to the end of the text
     *
     * @return string
     */
    private function attachTermDescription(Glossary $glossaryTerm, string $text){
        $termTooltipContent = "<div class='tooltip-painter' id='thayer-tooltip-content' style='display:none'>
                            <div class='photo'>
                                <img src='https://source.unsplash.com/random' alt=''/>
                            </div>
                            <div class='content'>
                                <div class='padder'>
                                    <div class='title'>".$glossaryTerm->term."</div>
                                        <div class='description' style='display:none'>Abbott Handerson Thayer (1849 - 1921) was an American artist, naturalist and teacher. 
                                            As a painter of portraits, figures, animals and landscapes, he enjoyed a certain prominence during his lifetime, 
                                            and his paintings are represented in the major American art collections. He is perhaps best known for his 'angel' 
                                            paintings, some of which use his children as models.
                                        </div>
                                        <div class='description'>
                                            ".$glossaryTerm->definition."
                                            <br>
                                            <a href='#'>Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>";

        $ret = $text.$termTooltipContent;
        return $ret;
    }

}






