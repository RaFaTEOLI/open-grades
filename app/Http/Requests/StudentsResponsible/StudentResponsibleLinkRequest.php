<?php

namespace App\Http\Requests\StudentsResponsible;

use Illuminate\Foundation\Http\FormRequest;

class StudentResponsibleLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "student_id" => "required|numeric|exists:users,id",
        ];
    }
}
