<?php

namespace App\Http\Requests\MobileOpportunity;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class MobileSalesInformationRequest extends FormRequest
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
        $date = Carbon::now()->subYears(18)->format('d/m/Y');

        return [
            'business_type' => 'required',
            'account_holder' => 'required',
            'date_of_birth' => 'required|date_format:d/m/Y|before_or_equal:' . $date,
            'business_name' => 'required',
            'landline_number' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required',
            'business_established_date' => 'required|date_format:m/Y',
            'current_network_account_number' => 'required',
            'special_requirements' => 'required',
            'network_porting_from' => 'required',
            'address_1_line_1' => 'required',
            'address_1_postcode' => 'required',
            'address_2_line_1' => 'required',
            'address_2_postcode' => 'required',
            'address_3_line_1' => 'required',
            'address_3_postcode' => 'required',
            'address_1_time_at_address' => 'required',
            'address_2_time_at_address' => 'required',
            'password' => 'required',
            'last_bill_date' => 'required',
            'last_bill_amount' => 'required',
        ];
    }
}
