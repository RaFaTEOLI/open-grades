<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\UserNotAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Validates if logged user is admin
    public static function isAdminOrFail()
    {
        $hasRole = Auth::user()->hasRole("admin");

        if (!$hasRole) {
            throw new UserNotAdmin("User is not admin");
        }
    }
}
