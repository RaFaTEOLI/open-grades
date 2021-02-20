<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            "display_name" => "required",
            "description" => "required",
        ];
    }
}
