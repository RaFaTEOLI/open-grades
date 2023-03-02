<?php

namespace App\Http\Requests\Statement;

use Illuminate\Foundation\Http\FormRequest;

class StatementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "subject" => "required",
            "statement" => "required",
        ];
    }
}
