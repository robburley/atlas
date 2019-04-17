<?php

namespace App\Http\Requests\EnergyOpportunity;

use Illuminate\Foundation\Http\FormRequest;

class EnergyOpportunityRequest extends FormRequest
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
            //
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
            'suppliers' => 'sometimes|required',
            'monthly_spend' => 'sometimes|required',
            'number_of_sites' => 'sometimes|required',
            'looking_for_prices' => 'sometimes|required',
            'direct_or_broker' => 'sometimes|required',
            'typical_contact_length' => 'sometimes|required',
            'supplier_to_avoid' => 'sometimes|required',
            'energy_procurement' => 'sometimes|required_without_all:price_comparison,kva_mapping_report,contract_validation,energy_audit',
            'price_comparison' => 'sometimes|required_without_all:energy_procurement,kva_mapping_report,contract_validation,energy_audit',
            'kva_mapping_report' => 'sometimes|required_without_all:energy_procurement,price_comparison,contract_validation,energy_audit',
            'contract_validation' => 'sometimes|required_without_all:energy_procurement,price_comparison,kva_mapping_report,energy_audit',
            'energy_audit' => 'sometimes|required_without_all:energy_procurement,price_comparison,kva_mapping_report,contract_validation',
            'notes' => 'required',
        ];
    }
}
