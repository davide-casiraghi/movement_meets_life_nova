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
            $pattern = "/\b$glossaryTerm->term\b/";
            $text = preg_replace_callback(
                $pattern,
                function($matches) use ($glossaryTerm){
                    $glossaryTermTemplate = "<a href='/glossaryTerms/".$glossaryTerm->id."' class='text-red-700'>".$glossaryTerm->term."</a>";
                    return $glossaryTermTemplate;
                },
                $text);
        }
        return $text;
    }
}




