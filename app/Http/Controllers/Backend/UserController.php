<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){

        $users = $this->userService->paginate(5);

        return view('Backend.user.index', [
            'users' => $users
        ]);
    }
}
