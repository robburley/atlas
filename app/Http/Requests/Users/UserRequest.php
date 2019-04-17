<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->ignore($this->user->id ?? null),
            ],
            'password' => [
                'min:6',
                'confirmed',
            ],
            'office_id' => 'required|numeric'
        ];

        if ($this->user) {
            array_push($rules['password'], 'nullable');
        }

        return $rules;
    }

    public function attributes()
    {
        return [
          'office_id' => 'office'
        ];
    }
}
