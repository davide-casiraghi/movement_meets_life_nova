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
        $count = 1;

        foreach ($glossaryTerms as $id => $glossaryTerm){
            $text = $this->replaceGlossaryTerm($glossaryTerm, $text, $count);
            $text = $this->attachTermDescription($glossaryTerm, $text, $count);

            $count++;
        }

        return $text;
    }

    /**
     * Replace glossary term
     *
     * @param \App\Models\Glossary $glossaryTerm
     * @param string $text
     *
     * @return string
     */
    private function replaceGlossaryTerm(Glossary $glossaryTerm, string $text, int $count) {
        $pattern = "/\b$glossaryTerm->term\b/";
        $text = preg_replace_callback(
            $pattern,
            function($matches) use ($glossaryTerm, $count){
                $glossaryTermTemplate = "<a href='/glossaryTerms/".$glossaryTerm->id."' class='text-red-700 has-glossary-term' id='glossary-term-".$count."'>".$glossaryTerm->term."</a>";
                return $glossaryTermTemplate;
            },
            $text);

        return $text;
    }

    /**
     * Attach the term tooltip content to the end of the text
     *
     * @param \App\Models\Glossary $glossaryTerm
     * @param string $text
     *
     * @return string
     */
    private function attachTermDescription(Glossary $glossaryTerm, string $text, int $count){
        $termTooltipContent = "<div class='tooltip-painter' id='glossary-definition-".$count."' style='display:none'>";
            $termTooltipContent .= "<div class='photo'>";
                $termTooltipContent .="<img src='https://source.unsplash.com/random' alt=''/>";
            $termTooltipContent .="</div>";
        $termTooltipContent .= "<div class='content'>";
            $termTooltipContent .= "<div class='padder'>";
                $termTooltipContent .= "<div class='title'>".$glossaryTerm->term."</div>";
                    $termTooltipContent .= "<div class='description' style='display:none'>Abbott Handerson Thayer (1849 - 1921) was an American artist, naturalist and teacher.";
                        $termTooltipContent .= "As a painter of portraits, figures, animals and landscapes, he enjoyed a certain prominence during his lifetime, ";
                        $termTooltipContent .= "and his paintings are represented in the major American art collections. He is perhaps best known for his 'angel'";
                        $termTooltipContent .= "paintings, some of which use his children as models.";
                    $termTooltipContent .= "</div>";
                    $termTooltipContent .= "<div class='description'>";
                        $termTooltipContent .= $glossaryTerm->definition;
                        $termTooltipContent .= "<br>";
                        $termTooltipContent .= "<a href='#'>Read more</a>";
                    $termTooltipContent .= "</div>";
                $termTooltipContent .=  "</div>";
            $termTooltipContent .=  "</div>";
        $termTooltipContent .= "</div>";

        $ret = $text.$termTooltipContent;
        return $ret;
    }

}






