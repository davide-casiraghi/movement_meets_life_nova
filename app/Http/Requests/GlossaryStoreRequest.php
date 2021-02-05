<?php

namespace App\Http\Requests;

use App\Rules\LettersAndWhitespaces;
use Illuminate\Foundation\Http\FormRequest;

class GlossaryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'term' => ['required', 'max:255', new LettersAndWhitespaces()],
            'definition' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'introimage' => ['nullable', 'image','mimes:jpg,jpeg,png|max:5120'], // 5MB
        ];
    }
}
