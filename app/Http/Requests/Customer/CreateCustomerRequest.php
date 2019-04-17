<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'company_name' => 'required|min:2|max:255',
            'telephone_number' => 'required|unique:customers,telephone_number|phone:AUTO,GB',
            'title' => 'required',
            'forename' => 'required',
            'surname' => 'required',
            'landline_number' => 'required|phone:AUTO,GB',
        ];
    }
}
