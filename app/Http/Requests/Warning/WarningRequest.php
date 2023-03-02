<?php

namespace App\Http\Requests\Warning;

use Illuminate\Foundation\Http\FormRequest;

class WarningRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "student_id" => "required",
            "class_id" => "required",
            "description" => "required",
        ];
    }
}
