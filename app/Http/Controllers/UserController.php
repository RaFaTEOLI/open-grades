<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index() {
        $user = $this->userRepository->all();

        return $user;
    }

    public function show($userId) {
        $user = $this->userRepository->findById($userId);

        return $user;
    }

    public function update($userId, $data) {
        $user = $this->userRepository->update($userId, $data);

        return $user;
    }

    public function destroy($userId) {
        $user = $this->userRepository->delete($userId);

        return true;
    }
}
