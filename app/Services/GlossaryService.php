<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\GlossarySearchRequest;
use App\Http\Requests\GlossaryStoreRequest;
use App\Models\Glossary;
use App\Models\GlossaryVariant;
use App\Repositories\GlossaryRepository;
use App\Repositories\GlossaryVariantRepository;

class GlossaryService
{
    private GlossaryRepository $glossaryRepository;
    private GlossaryVariantRepository $glossaryVariantRepository;

    /**
     * GlossaryService constructor.
     *
     * @param \App\Repositories\GlossaryRepository $glossaryRepository
     * @param \App\Repositories\GlossaryVariantRepository $glossaryVariantRepository
     */
    public function __construct(
        GlossaryRepository $glossaryRepository,
        GlossaryVariantRepository $glossaryVariantRepository
    ) {
        $this->glossaryRepository = $glossaryRepository;
        $this->glossaryVariantRepository = $glossaryVariantRepository;
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
     * Check in the text if there is any published Glossary Term variant,
     * and make them hoverable to show the tooltip.
     *
     * It adds also the hidden contents to show in the tooltips
     * when the terms are hovered.
     *
     * @param string $text
     *
     * @return string
     */
    public function markGlossaryTerms(string $text): string
    {
        $glossaryTermsWithVariants = $this->glossaryRepository->getAllWithVariants();

        $count = 1;
        $glossaryTermPresent = false;
        foreach ($glossaryTermsWithVariants as $glossaryTermId => $glossaryTerm) {
            foreach ($glossaryTerm->variants as $variant) {
                $currentLanguageVariantTerm = $variant->getTranslation('term', app()->getLocale());

                $text = $this->replaceGlossaryVariant($currentLanguageVariantTerm, $glossaryTerm->id, $text, $count);

                if (self::variantIsPresent($text, $currentLanguageVariantTerm)) {
                    $glossaryTermPresent = true;
                }
            }

            if ($glossaryTermPresent) {
                $text = $this->attachTermDescription($glossaryTerm, $text);
            }

            $count++;
            $glossaryTermPresent = false;
        }

        return $text;
    }

    /**
     * Check if the term is present in the text
     *
     * @param string $text
     * @param string $term
     *
     * @return bool
     */
    public function variantIsPresent(string $text, string $term): bool
    {
        if (strpos($text, $term) !== false) {
            return true;
        }
        return false;
    }

    /**
     * Replace glossary term
     *
     * @param string $currentLanguageVariantTerm
     * @param int $glossaryTermId
     * @param string $text
     * @param int $count
     *
     * @return string
     */
    public function replaceGlossaryVariant(string $currentLanguageVariantTerm, int $glossaryTermId, string $text, int &$count): string
    {
        //$pattern = "/\b$glossaryTerm->term\b/";
        $pattern = "~<a .*?</a>(*SKIP)(*F)|\b$currentLanguageVariantTerm\b~";

        $text = preg_replace_callback(
            $pattern,
            function ($matches) use ($currentLanguageVariantTerm, $glossaryTermId, $count) {
                $glossaryTermTemplate = "<a href='/glossaryTerms/".$glossaryTermId."' class='text-red-700 has-glossary-term glossary-term-".$count."' data-termFoundId='".$count."' data-definitionId='".$glossaryTermId."'>".$currentLanguageVariantTerm."</a>";
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
     *
     * @return string
     */
    public function attachTermDescription(Glossary $glossaryTerm, string $text): string
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

    /**
     * Return the title question to show in the Glossary show view
     *
     * @param \App\Models\Glossary $glossaryTerm
     *
     * @return string
     */
    public function getGlossaryTermTitleQuestion(Glossary $glossaryTerm): string
    {
        $ret = "";

        switch ($glossaryTerm->question_type) {
            case 1:
                $ret .= __('glossary.what_is');
                break;
            case 2:
                $ret .= __('glossary.what_does_it_mean');
                break;
        }
        $ret .= " {$glossaryTerm->term} ?" ;

        return $ret;
    }

}
