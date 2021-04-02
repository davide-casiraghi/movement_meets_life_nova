<?php


namespace App\Generators;

use Spatie\SchemaOrg\Type;

/**
 * Interface StructuredDataScriptGenerator
 * Implementations generate the script for specific entity.
 *
 * @see https://schema.org
 * @see https://github.com/spatie/schema-org
 *
 * @package App\Generators
 */
interface StructuredDataScriptGenerator
{
    /**
     * Generating the script for a specific Schema.org type.
     *
     * @return Type
     */
    public function generate(): Type;
}
