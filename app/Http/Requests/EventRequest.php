<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|max:255',
            'date_from' => 'required|date',
            'date_to' => ['required', 'date', function ($attribute, $value, $fail) {
                if (strtotime($this->date_from) > strtotime($value)) {
                    $fail('Date to must be greater than or equal to date from.');
                }
            }],
            'days' => ['required', function ($attribute, $value, $fail) {
                if (!in_array(true, $value)) {
                    $fail('Please select atleast 1 day.');
                }
            }],
        ];
    }
}
