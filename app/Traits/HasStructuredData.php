<?php


namespace App\Traits;


use Spatie\SchemaOrg\Type;

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
     * Generate the script for a Schema.org type.
     *
     * @return Type
     */
    abstract protected function generateStructuredDataScript() : Type;

    /**
     * Render a json-ld script tag for the entity that implements this trait.
     *
     * @return string
     */
    public function toJsonLdScript() : string
    {
        return $this->generateStructuredDataScript()->toScript();
    }
}
