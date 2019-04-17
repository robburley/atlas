<?php

namespace App\Http\Requests\MobileOpportunity;


use Illuminate\Foundation\Http\FormRequest;

class DealCalcRequest extends FormRequest
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
            'primary_connections.*.tariff_id.required'   => 'Each Primary Connection must have a tariff name',
            'secondary_connections.*.tariff_id.required' => 'Each Secondary Connection must have a tariff name',
            'primary_connections.*.total.min'            => 'Each Primary Connection must have a total',
            'secondary_connections.*.total.min'          => 'Each Secondary Connection must have a total',
            'contributions.*.name.required'              => 'Each Contribution must have a name',
            'handsets.*.handset_id.required'             => 'Each Handset must be selected',
            'accessories.*.name.required'                => 'Each Accessory must have a name',
            'credits.*.name.required'                    => 'Each Credit must have a name',
            'overview.profitMargin.min'                  => 'The profit margin may not be less than 30%. Call AQ to authorise this.',
            'overview.discountMargin.max'                => 'The discount margin may not be greater than 70%. Call AQ to authorise this.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = collect([
            'name'                  => 'required',
            'primary_connections'   => 'required_without:secondary_connections',
            'secondary_connections' => 'required_without:primary_connections',

            'primary_connections.*.tariff_id'   => 'sometimes|required',
            'primary_connections.*.total'       => 'numeric|min:1',
            'secondary_connections.*.tariff_id' => 'sometimes|required',
            'secondary_connections.*.total'     => 'numeric|min:1',

            'contributions.*.name'  => 'sometimes|required',
            'handsets.*.handset_id' => 'sometimes|required',
            'accessories.*.name'    => 'sometimes|required',
            'credits.*.name'        => 'sometimes|required',
        ]);

        if (!auth()->user()->hasPermission('ignore_deal_calculator_authorisation')) {
            $rules->put('overview.profitMargin', 'numeric|min:30');
            $rules->put('overview.discountMargin', 'numeric|max:70');
        }

        return $rules->toArray();
    }
}
