<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\HttpStatus;

class ValidationController extends Controller
{
    public static function isIdValid($id) {
        if (is_numeric($id)) {
            return true;
        } else {
            return response()->json(['error' => 'Invalid Id'], HttpStatus::BAD_REQUEST);
        }
    }
}
