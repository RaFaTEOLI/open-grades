<?php

namespace App\Http\Requests\Year;

use Illuminate\Foundation\Http\FormRequest;

class YearRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "start_date" => "required|date",
            "end_date" => "required|date",
        ];
    }
}
