<?php


namespace App\Generators;

use App\Models\Glossary;
use Spatie\SchemaOrg\DefinedTerm;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;

/**
 * Class GlossaryStructuredDataScriptGenerator
 * Generate the script for Glossary entity.
 *
 * @package App\Generators
 */
class GlossaryStructuredDataScriptGenerator implements StructuredDataScriptGeneratorInterface
{
    private Glossary $glossary;

    public function __construct(Glossary $glossary)
    {
        $this->glossary = $glossary;
    }

    /**
     * Generate the script for a person Schema.org type.
     * @see https://schema.org/DefinedTerm
     *
     * @return Type
     */
    public function generate(): Type
    {
        return Schema::definedTerm()
            ->name($this->glossary->term)
            ->if($this->glossary->variants->isNotEmpty(), function (DefinedTerm $schema) {
                   $schema->alternateName($this->glossary->variants->map(function ($item, $key) {
                                               return $item['term'];
                                           })->all());
            })
            ->description($this->glossary->definition . ' ' . $this->glossary->body)
            ->if($this->glossary->hasMedia('introimage'), function (DefinedTerm $schema) {
                $schema->image($this->glossary->getMedia('introimage')->first()->getUrl());
            })
            ->url(env('APP_URL').'/glossaries/'.$this->glossary->slug);
    }
}
