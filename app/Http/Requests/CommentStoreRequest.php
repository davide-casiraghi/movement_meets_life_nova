<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
            'email' => ['required','email'],
            'name' => ['required'],
            'body' => ['required'],
        ];
    }

    /**
     * Get the translated validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'body.required' => __('comment.body_required'),
            'name.required' => __('comment.name_required'),
            'email.required' => __('comment.email_required'),
            'email.email' => __('comment.email_invalid'),
        ];
    }
}
