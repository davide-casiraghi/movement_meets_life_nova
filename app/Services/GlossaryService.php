<?php

namespace App\Services;

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
     * @param \App\Http\Requests\GlossaryStoreRequest $data
     *
     * @return \App\Models\Glossary
     */
    public function createGlossary(GlossaryStoreRequest $data): Glossary
    {
        $glossary = $this->glossaryRepository->store($data->all());

        $this->storeImages($glossary, $data);

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
    public function updateGlossary(GlossaryStoreRequest $data, int $glossaryId): Glossary
    {
        $glossary = $this->glossaryRepository->update($data->all(), $glossaryId);

        $this->storeImages($glossary, $data);

        return $glossary;
    }

    /**
     * Return the gender from the database
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
     * @return string
     */
    public function markGlossaryTerms($text)
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
    private function termIsPresent($text, $term): bool
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
        $pattern = "/\b$glossaryTerm->term\b/";
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
        $termTooltipContent = "<div class='tooltip-painter' id='glossary-definition-".$glossaryTerm->id."' style='display:none'>";
        $termTooltipContent .= "<div class='photo'>";
        $termTooltipContent .="<img src='https://source.unsplash.com/random/300x200' alt=''/>";
        $termTooltipContent .="</div>";
        $termTooltipContent .= "<div class='content p-2 overflow-auto'>";
        $termTooltipContent .= "<div class='padder'>";
        $termTooltipContent .= "<div class='title'>".$glossaryTerm->term."</div>";
        $termTooltipContent .= "<div class='description overflow-auto'>";
        $termTooltipContent .= $glossaryTerm->definition;
        $termTooltipContent .= "<br>";
        $termTooltipContent .= "<a href='#'>Read more</a>";
        $termTooltipContent .= "</div>";
        $termTooltipContent .=  "</div>";
        $termTooltipContent .=  "</div>";
        $termTooltipContent .= "</div>";

        $ret = $text . $termTooltipContent;
        return $ret;
    }

    /**
     * Store the uploaded introimage in the Spatie Media Library
     *
     * @param \App\Models\Glossary $glossary
     * @param \App\Http\Requests\GlossaryStoreRequest $data
     *
     * @return void
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    private function storeImages(Glossary $glossary, GlossaryStoreRequest $data): void
    {
        if ($data->file('introimage')) {
            $introimage = $data->file('introimage');
            if ($introimage->isValid()) {
                $glossary->addMedia($introimage)->toMediaCollection('introimage');
            }
        }

        if ($data['introimage_delete'] == 'true') {
            $mediaItems = $glossary->getMedia('introimage');
            if (!is_null($mediaItems[0])) {
                $mediaItems[0]->delete();
            }
        }
    }

    /**
     * Get the post search parameters
     *
     * @param \App\Http\Requests\GlossarySearchRequest $request
     *
     * @return array
     */
    public function getSearchParameters(GlossarySearchRequest $request): array
    {
        $searchParameters = [];
        $searchParameters['term'] = $request->term ?? null;
        $searchParameters['status'] = $request->status ?? null;

        return $searchParameters;
    }
}
