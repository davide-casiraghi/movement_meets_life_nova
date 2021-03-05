<?php


namespace App\Services;


use App\Models\Glossary;
use App\Models\GlossaryVariant;
use App\Repositories\GlossaryVariantRepositoryInterface;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GlossaryVariantService
{
    private GlossaryVariantRepositoryInterface $glossaryVariantRepository;

    /**
     * GlossaryVariantService constructor.
     * @param  GlossaryVariantRepositoryInterface  $glossaryVariantRepository
     */
    public function __construct(GlossaryVariantRepositoryInterface $glossaryVariantRepository)
    {
        $this->glossaryVariantRepository = $glossaryVariantRepository;
    }

    /**
     * Create one glossary variant that has the same name of the Glossary term
     *
     * @param  Glossary  $glossary
     * @return GlossaryVariant
     */
    public function createGlossaryVariant(Glossary $glossary): GlossaryVariant
    {
        $data = [
            'lang' => [],
            'glossary_id' => $glossary->id
        ];
        $lang = [];
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $lang[$key] = $glossary->term;
        }
        $data['lang'] = $lang;
        return $this->glossaryVariantRepository->store($data);
    }
}
