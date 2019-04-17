<?php

namespace App\Http\Requests\FixedLineOpportunity;

use Illuminate\Foundation\Http\FormRequest;

class FixedLineOpportunityRequest extends FormRequest
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
            'company_name.unique' => 'The company name already exists.',
            'telephone_number.unique' => 'The telephone number already exists.',
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
            'networks' => 'sometimes|required',
            'voice_users' => 'sometimes|required|numeric',
            'data_users' => 'sometimes|required|numeric',
            'monthly_spend' => 'sometimes|required',
            'contract_end_date' => 'sometimes|required',
            'contract_end_date_confirmed' => 'sometimes|required',
            'direct_dealer' => 'sometimes|required',
            'decide_30_days' => 'sometimes|required',
            'take_new_number' => 'sometimes|required',
            'roaming_international' => 'sometimes|required',
            'new_hardware' => 'sometimes|required',
        ];
    }
}
