<?php

namespace App\Rules;

use App\InvitationLink;
use App\Repositories\InvitationLinkRepository;
use Illuminate\Contracts\Validation\Rule;

class ValidLink implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $invitationLinkRepository = new InvitationLinkRepository();
        return $invitationLinkRepository->validateHash($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.invalid_link');
    }
}
