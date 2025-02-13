<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\ProvinceRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

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

        $groupMember = [
          (object)[ 'code' => 1, 'name' => 'Admin'],
          (object)[ 'code' => 2, 'name' => 'Customer']

        ];

        return view('Backend.user.create', [
            'provinces' => $provinces,
            'groupMember' => $groupMember
        ]);
    }

    public function store(StoreUserRequest $request){
        if($this->userService->create($request)){
            return redirect()->route('user.index')->with('success', 'Added new member successfully!');
        }

        return redirect()->route('user.index')->with('success', 'Failed to add new member!');
    }

    public function edit(User $user){
        $provinces = $this->provinceRepository->getAll();

        $groupMember = [
            (object)[ 'code' => 1, 'name' => 'Admin'],
            (object)[ 'code' => 2, 'name' => 'Customer']

          ];
        return view('backend.user.create', [
            'groupMember' => $groupMember,
            'provinces' => $provinces,
            'user' => $user
        ]);
    }

    public function update($id, UpdateUserRequest $request){
        if($this->userService->update($id, $request)){
            return redirect()->route('user.index')->with('success', 'Updated member successfully!');
        }

        return redirect()->route('user.index')->with('success', 'Failed to updated member!');
    }
}
