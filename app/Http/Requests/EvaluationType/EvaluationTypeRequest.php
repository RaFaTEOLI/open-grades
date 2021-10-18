<?php

namespace App\Http\Requests\EvaluationType;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "weight" => "numeric|min:1|required"
        ];
    }
}
