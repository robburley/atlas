<?php

namespace App\Http\Requests\MobileOpportunity;


use Illuminate\Foundation\Http\FormRequest;

class TariffMatchRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'lines.*.type.required'    => 'Each line must have a type',
            'lines.*.network.required' => 'Each line must have a network',
            'lines.*.name.required'    => 'Each line must have a name',
            'lines.*.device.required'  => 'Each line must have a device',
            'lines.*.mins.required'    => 'Each line must have minutes',
            'lines.*.data.required'    => 'Each line must have data',
            'current_monthly_cost.min' => 'The average monthly cost must be greater than 0',
            'lines.required'           => 'You must add atleast 1 line',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->is('api/tariff-match/update/1')) {
            return [
                'lines'                 => 'required',
                'current_monthly_cost'  => 'required|numeric|min:1',
                'step'                  => 'required|numeric',
                'mobile_opportunity_id' => 'required|numeric',

                'lines.*.type'    => 'required',
                'lines.*.network' => 'required',
                'lines.*.name'    => 'required',
                'lines.*.device'  => 'required',
                'lines.*.mins'    => 'sometimes|required|numeric|min:0',
                'lines.*.data'    => 'sometimes|required|numeric|min:0',
            ];
        }

        if ($this->is('api/tariff-match/update/2')) {
            return [
                'requirements'          => 'required',
                'requirements.*.type'   => 'required',
                'requirements.*.name'   => 'required',
                'requirements.*.device' => 'required',
                'requirements.*.mins'   => 'sometimes|required|numeric|min:0',
                'requirements.*.data'   => 'sometimes|required|numeric|min:0',

                'termination_fees'           => 'required',
                'termination_fees.*.network' => 'required',
                'termination_fees.*.fee'     => 'required|numeric|min:0',
            ];
        }

        //step 3
        return [];
    }
}
