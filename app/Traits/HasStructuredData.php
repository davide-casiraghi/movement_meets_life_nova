<?php


namespace App\Traits;

use \App\Generators\StructuredDataScriptGenerator;

/**
 * Trait HasStructuredData to implement a builder for all Schema.org types
 * and their properties using the spatie/schema-org package.
 *
 * @see https://schema.org
 * @see https://github.com/spatie/schema-org
 *
 * @package App\Traits
 */
trait HasStructuredData
{

    /**
     * Get the specific structured data script generator.
     *
     * @return StructuredDataScriptGenerator
     */
    protected abstract function getStructuredDataScriptGenerator() : StructuredDataScriptGenerator;

    /**
     * Render a json-ld script tag for the entity that implements this trait.
     *
     * @return string
     */
    public function toJsonLdScript() : string
    {
        return $this->getStructuredDataScriptGenerator()
                    ->generate()
                    ->toScript();
    }
}
