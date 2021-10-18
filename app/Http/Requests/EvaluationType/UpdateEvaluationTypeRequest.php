<?php

namespace App\Http\Requests\EvaluationType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "weight" => "numeric|min:1"
        ];
    }
}
