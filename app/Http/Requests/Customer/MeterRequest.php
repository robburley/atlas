<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class MeterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'site_id' => 'required|numeric',
            'type' => 'required',
            'top_line' => 'required',
            'bottom_line' => 'required',
            'quantity' => 'required',
            'day_rate' => 'required',
            'night_rate' => 'required',
            'current_standing_charge' => 'required',
            'contract_end_date' => 'required|date_format:d/m/Y',
        ];
    }
}
