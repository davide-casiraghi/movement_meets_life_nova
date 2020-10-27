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
        //dump($text);
        $glossaryTerms = Glossary::where('is_published', 1)->pluck('term');
        //dump($glossaryTerms);
        foreach ($glossaryTerms as $glossaryTerm){
            $pattern = "/\b$glossaryTerm\b/";
            //dump($pattern);
            $text = preg_replace_callback(
                $pattern,
                function($matches) use ($glossaryTerm){
                    $glossaryTermTemplate = "<a href='/#' class='text-red-700'>".$glossaryTerm."</a>";
                    return $glossaryTermTemplate;
                },
                $text);

            //dd($text);
        }


        return $text;
    }
}




