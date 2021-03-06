<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialStoreRequest extends FormRequest
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
            'feedback' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','max:255'],
            'profession' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'string'],
            'photo' => 'mimes:jpg,jpeg,png|max:5120', // 5MB
            'personal_data_agreement' => ['required'],
            'publish_agreement' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'photo.mimes' => 'Only jpeg, jpg and png images are allowed',
            'photos.max' => 'Maximum allowed size for an image is 5MB',
        ];
    }
}







