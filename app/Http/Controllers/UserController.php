<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = (new UserRepository());
    }

    public function index()
    {
        $user = $this->userRepository->all();

        return $user;
    }

    public function show($userId)
    {
        $user = $this->userRepository->findById($userId);

        return $user;
    }

    public function update($userId, $data)
    {
        $user = $this->userRepository->update($userId, $data);

        return $user;
    }

    public function destroy($userId)
    {
        $user = $this->userRepository->delete($userId);

        return true;
    }
}
