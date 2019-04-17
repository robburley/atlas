<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationFormRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "telephone" => "required|numeric",
            "mobile" => "required|numeric",
            "email" => "required|email",
            "date_of_birth" => "required|date_format:d/m/Y",
            'location' => 'required',
            'cv' => 'required|file',
            'commitments' => "required",
            'children' => "required",
            'married' => "required",
            'experience' => "required",
            'current_role' => "required",
            'change_reason' => "required",
            'best_job' => "required",
            'biggest_achievement' => "required",
            'drive' => "required",
            'bring_to_business' => "required",
            'suitable_reason' => "required",
            'best_attributes' => "required",
            'development_areas' => "required",
            'confidence' => "required|numeric",
        ];
    }
}
