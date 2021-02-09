<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'event_category_id' => ['required'],
            'venue_id' => ['required'],
            'description' => ['required', 'string'],
            'repeat_weekly_on' => [Rule::requiredIf(request()->repeat_type == 2), 'array'],

            /*'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'venue_id' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'repeat_until' => Rule::requiredIf($request->repeat_type == 2 || $request->repeat_type == 3),
            'repeat_weekly_on_day' => Rule::requiredIf($request->repeat_type == 2),
            'on_monthly_kind' => Rule::requiredIf($request->repeat_type == 3),
            'contact_email' => 'nullable|email',
            'facebook_event_link' => 'nullable|url',
            'website_event_link' => 'nullable|url',*/
        ];
    }
}

/*
 *
 *
 * $messages = [
            'repeat_weekly_on_day[].required' => 'Please specify which day of the week is repeting the event.',
            'on_monthly_kind.required' => 'Please specify the kind of monthly repetion',
            'endDate.same' => 'If the event is repetitive the start date and end date must match',
            'facebook_event_link.url' => 'The facebook link is invalid. It should start with https://',
            'website_event_link.url' => 'The website link is invalid. It should start with https://',
            'image.max' => 'The maximum image size is 5MB. If you need to resize it you can use: www.simpleimageresizer.com',
        ];


// End date and start date must match if the event is repetitive
        $validator->sometimes('endDate', 'same:startDate', function ($input) {
            return $input->repeat_type > 1;
        });
 */

