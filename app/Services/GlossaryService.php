<?php

namespace App\Services;

use App\Http\Requests\GlossaryStoreRequest;
use App\Models\Glossary;
use App\Repositories\GlossaryRepository;

class GlossaryService {

    private $glossaryRepository;

    public function __construct(
        GlossaryRepository $glossaryRepository
    ) {
        $this->glossaryRepository = $glossaryRepository;
    }

    /**
     * Create a glossary term
     *
     * @param \App\Http\Requests\GlossaryStoreRequest $data
     *
     * @return \App\Models\Glossary
     */
    public function createGlossary(GlossaryStoreRequest $data)
    {
        $glossary = $this->glossaryRepository->store($data);

        return $glossary;
    }

    /**
     * Update the gender
     *
     * @param \App\Http\Requests\GlossaryStoreRequest $data
     * @param int $glossaryId
     *
     * @return \App\Models\Glossary
     */
    public function updateGlossary(GlossaryStoreRequest $data, int $glossaryId)
    {
        $glossary = $this->glossaryRepository->update($data, $glossaryId);

        return $glossary;
    }

    /**
     * Return the gender from the database
     *
     * @param int $glossaryId
     *
     * @return \App\Models\Glossary
     */
    public function getById(int $glossaryId)
    {
        return $this->glossaryRepository->getById($glossaryId);
    }

    /**
     * Get all the glossary terms
     *
     * @return iterable
     */
    public function getGlossaries()
    {
        return $this->glossaryRepository->getAll();
    }

    /**
     * Delete the glossary terms from the database
     *
     * @param int $glossaryId
     */
    public function deleteGlossary(int $glossaryId): void
    {
        $this->glossaryRepository->delete($glossaryId);
    }



    /**
     * Finds the matches of all the words of the glossary in the specified text
     *
     * @return string
     */
    public function markGlossaryTerms($text)
    {
        $glossaryTerms = Glossary::currentStatus('Published')->get();
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
                $termTooltipContent .="<img src='https://source.unsplash.com/random/300x200' alt=''/>";
            $termTooltipContent .="</div>";
        $termTooltipContent .= "<div class='content p-2'>";
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






