<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "subject_id" => "required",
            "grade_id" => "required",
            "user_id" => "required",
        ];
    }
}
