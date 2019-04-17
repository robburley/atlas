<?php

namespace App\Http\Requests\Calendar;

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
            "title" => 'required',
            "body" => 'required',
            "type" => "required",
            "date_time" => 'required|date_format:d/m/Y H:i:s',
//            "date.time" => 'required|date_format:d-m-Y',
//            "date.hour" => 'required|integer|max:24',
//            "date.minute" => 'required|integer|max:60',
        ];
    }

    public function attributes()
    {
        return [
            'date.time' => 'date',
            'date.hour' => 'hour',
            'date.minute' => 'minute',
        ];
    }
}
