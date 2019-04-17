<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerNoteRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required',
            'customer_note_type_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'customer_note_type_id' => 'Note type'
        ];
    }
}
