<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InternationalPhone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * Example phone numbers
     *    0821 12 34 567
     *    08211234567
     *    0821-1234567
     *    0821-12 34 567
     *    0821 - 1234567
     *    0821 - 12 34 567
     *    0821/1234567
     *    0821/12 34 567
     *    0821 / 1234567
     *    0821 / 12 34 56 7
     *    +49(821) 1234-567
     *    +49 (821) 12 34 - 567
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match("/^[0-9\-\(\)\/\+\s]*$/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given phone number is not in a correct format.';
    }
}
