<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class AdminController extends Controller
{
    // Validates if logged user is admin
    public static function isAdminOrFail() {
        $user = User::where('id', Auth::id())->where('admin', 1)->first();

        if (!$user) throw new Exception('User is not admin');
    }
}
