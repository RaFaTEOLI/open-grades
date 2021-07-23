<?php

namespace App\Http\Requests\InvitationLink;

use Illuminate\Foundation\Http\FormRequest;

class InvitationLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "type" => "required|in:STUDENT,TEACHER",
        ];
    }
}
