<?php

namespace App\Http\Requests\FixedLineOpportunity;

use Illuminate\Foundation\Http\FormRequest;

class CommercialsRequest extends FormRequest
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
            'lines.required' => 'There must be atleast 1 line',

            'lines.*.type.required' => 'Each Line Must have a type',
            'lines.*.monthly_line_rental.required' => 'Each Line Must have a monthly line rental',
            'lines.*.monthly_line_rental.min' => 'Each Line Must have a monthly line rental over £0',
            'lines.*.installation_postcode.required' => 'Each Line Must have an installation postcode.',
            'lines.*.has1571.required' => 'Each Line Must have 1571',
            'lines.*.call_divert.required' => 'Each Line Must have call divert.',
            'lines.*.call_waiting.required' => 'Each Line Must have call waiting.',
            'lines.*.caller_display.required' => 'Each Line Must have caller display.',
            'lines.*.broadband.required' => 'Each Line Must have broadband',

            'primary_connections.*.tariff_id.required' => 'Each Primary Connection must have a tariff name',
            'secondary_connections.*.tariff_id.required' => 'Each Secondary Connection must have a tariff name',
            'primary_connections.*.total.min' => 'Each Primary Connection must have a total',
            'secondary_connections.*.total.min' => 'Each Secondary Connection must have a total',
            'contributions.*.name.required' => 'Each Contribution must have a name',
            'handsets.*.name.required' => 'Each Handset must have a name',
            'accessories.*.name.required' => 'Each Accessory must have a name',
            'credits.*.name.required' => 'Each Credit must have a name',
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
            'lines' => 'required',

            'lines.*.type' => 'required|numeric|min:0',
            'lines.*.monthly_line_rental' => 'required|numeric|min:1',
            'lines.*.installation_postcode' => 'required',
            'lines.*.has1571' => 'required|numeric|min:0',
            'lines.*.call_divert' => 'required|numeric|min:0',
            'lines.*.call_waiting' => 'required|numeric|min:0',
            'lines.*.caller_display' => 'required|numeric|min:0',
            'lines.*.broadband' => 'required|numeric|min:0',

            'admin_charge_confirmed' => 'accepted',
            'broad_band_confirmed' => $this->get('hasBroadBand') ? 'accepted' : 'present',
            'call_bundle_local_national' => $this->get('call_bundle_local_national') > 0 ? 'numeric|min:6' : 'numeric|min:0',
            'call_bundle_mobile' => $this->get('call_bundle_mobile') > 0 ? 'numeric|min:6' : 'numeric|min:0',
        ];
    }
}
