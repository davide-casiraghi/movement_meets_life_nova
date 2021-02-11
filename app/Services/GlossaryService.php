<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\GlossarySearchRequest;
use App\Http\Requests\GlossaryStoreRequest;
use App\Models\Glossary;
use App\Repositories\GlossaryRepository;

class GlossaryService
{
    private GlossaryRepository $glossaryRepository;

    /**
     * GlossaryService constructor.
     *
     * @param \App\Repositories\GlossaryRepository $glossaryRepository
     */
    public function __construct(
        GlossaryRepository $glossaryRepository
    ) {
        $this->glossaryRepository = $glossaryRepository;
    }

    /**
     * Create a glossary term
     *
     * @param \App\Http\Requests\GlossaryStoreRequest $request
     *
     * @return \App\Models\Glossary
     */
    public function createGlossary(GlossaryStoreRequest $request): Glossary
    {
        $glossary = $this->glossaryRepository->store($request->all());
        ImageHelpers::storeImages($glossary, $request, 'introimage');

        return $glossary;
    }

    /**
     * Update the glossary
     *
     * @param \App\Http\Requests\GlossaryStoreRequest $request
     * @param int $glossaryId
     *
     * @return \App\Models\Glossary
     */
    public function updateGlossary(GlossaryStoreRequest $request, int $glossaryId): Glossary
    {
        $glossary = $this->glossaryRepository->update($request->all(), $glossaryId);

        ImageHelpers::storeImages($glossary, $request, 'introimage');
        ImageHelpers::deleteImages($glossary, $request, 'introimage');

        return $glossary;
    }

    /**
     * Return the glossary from the database
     *
     * @param int $glossaryId
     *
     * @return \App\Models\Glossary
     */
    public function getById(int $glossaryId): Glossary
    {
        return $this->glossaryRepository->getById($glossaryId);
    }

    /**
     * Get all the glossary terms
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGlossaries(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->glossaryRepository->getAll($recordsPerPage, $searchParameters);
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
     * @param string $text
     *
     * @return string
     */
    public function markGlossaryTerms(string $text): string
    {
        $glossaryTerms = Glossary::currentStatus('published')->get();
        $count = 1;

        foreach ($glossaryTerms as $id => $glossaryTerm) {
            $text = $this->replaceGlossaryTerm($glossaryTerm, $text, $count);

            if (self::termIsPresent($text, $glossaryTerm->term)) {
                $text = $this->attachTermDescription($glossaryTerm, $text);
            }

            $count++;
        }

        // Check which terms are present and attach just them to the page!!!
        //$text = $this->attachTermDescription($glossaryTerm, $text, $count);


        return $text;
    }

    /**
     * Check if the term is present in the text
     *
     * @param $text
     * @param $term
     *
     * @return bool
     */
    public function termIsPresent($text, $term): bool
    {
        if (strpos($text, $term) !== false) {
            return true;
        }
        return false;
    }

    /**
     * Replace glossary term
     *
     * @param \App\Models\Glossary $glossaryTerm
     * @param string $text
     * @param int $count
     *
     * @return string
     */
    private function replaceGlossaryTerm(Glossary $glossaryTerm, string $text, int &$count): string
    {
        //$pattern = "/\b$glossaryTerm->term\b/";
        $pattern = "~<a .*?</a>(*SKIP)(*F)|\b$glossaryTerm->term\b~";

        $text = preg_replace_callback(
            $pattern,
            function ($matches) use ($glossaryTerm, $count) {
                $glossaryTermTemplate = "<a href='/glossaryTerms/".$glossaryTerm->id."' class='text-red-700 has-glossary-term glossary-term-".$count."' data-termFoundId='".$count."' data-definitionId='".$glossaryTerm->id."'>".$glossaryTerm->term."</a>";
                return $glossaryTermTemplate;
                $count++;
            },
            $text
        );

        return $text;
    }

    /**
     * Attach the term tooltip content to the end of the text
     *
     * @param \App\Models\Glossary $glossaryTerm
     * @param string $text
     * @param int $count
     *
     * @return string
     */
    private function attachTermDescription(Glossary $glossaryTerm, string $text): string
    {
        $termTooltipContent = "<div class='tooltip-painter' id='glossary-definition-" . $glossaryTerm->id . "' style='display:none'>";
        $termTooltipContent .= "<div class='photo'>";
        if($glossaryTerm->hasMedia('introimage')){
            $termTooltipContent .= "<img src='".$glossaryTerm->getMedia('introimage')[0]->getUrl('thumb')."' alt=''/>";
        }
        $termTooltipContent .= "</div>";
        $termTooltipContent .= "<div class='content p-2 overflow-auto'>";
        $termTooltipContent .= "<div class='padder'>";
        $termTooltipContent .= "<div class='title font-bold'>" . ucfirst($glossaryTerm->term) . "</div>";
        $termTooltipContent .= "<div class='description w-72 py-2'>";
        $termTooltipContent .= $glossaryTerm->definition;
        $termTooltipContent .= "<br>";
        $termTooltipContent .= "<div class='mt-2'>";
        $termTooltipContent .= "<a href='" . route('glossary.show',$glossaryTerm->id) . "'>Read more</a>";  // route('glossary.show',$glossaryTerm->id)
        $termTooltipContent .= "</div>";
        $termTooltipContent .= "</div>";
        $termTooltipContent .=  "</div>";
        $termTooltipContent .=  "</div>";
        $termTooltipContent .= "</div>";

        $ret = $text . $termTooltipContent;
        return $ret;
    }

}
