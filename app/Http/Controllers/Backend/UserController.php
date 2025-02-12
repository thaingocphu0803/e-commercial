<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepository;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;

    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        )
    {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
    }

    public function index(){

        $users = $this->userService->paginate(5);

        return view('Backend.user.index', [
            'users' => $users
        ]);
    }

    public function create(){
        $provinces = $this->provinceRepository->getAll();

        return view('Backend.user.create', [
            'provinces' => $provinces
        ]);
    }
}
