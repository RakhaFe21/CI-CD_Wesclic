<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WithoutSpaces implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Use a regular expression to check if the value contains spaces
        return !preg_match('/\s/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute cannot contain spaces.';
    }
}
