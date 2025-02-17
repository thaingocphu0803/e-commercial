<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\ProvinceRepository;
use App\Services\UserCatalougeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userCatalougeService;

    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserCatalougeService $userCatalougeService
        )
    {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userCatalougeService = $userCatalougeService;
    }

    public function index(Request $request){

        $users = $this->userService->paginate($request);
        $userCatalouges = $this->userCatalougeService->getAll();


        return view('Backend.user.user.index', [
            'users' => $users,
            'groupMember' => $userCatalouges
        ]);
    }

    public function create(){
        $provinces = $this->provinceRepository->getAll();
        $userCatalouges = $this->userCatalougeService->getAll();

        return view('Backend.user.user.create', [
            'provinces' => $provinces,
            'groupMember' => $userCatalouges
        ]);
    }

    public function store(StoreUserRequest $request){
        if($this->userService->create($request)){
            return redirect()->route('user.index')->with('success', 'Added new member successfully!');
        }

        return redirect()->route('user.index')->with('error', 'Failed to add new member!');
    }

    public function edit(User $user){
        $provinces = $this->provinceRepository->getAll();
        $userCatalouges = $this->userCatalougeService->getAll();

        return view('backend.user.user.create', [
            'groupMember' => $userCatalouges,
            'provinces' => $provinces,
            'user' => $user
        ]);
    }

    public function update($id, UpdateUserRequest $request){

        if($this->userService->update($id, $request)){
            return redirect()->route('user.index')->with('success', 'Updated member successfully!');
        }

        return redirect()->route('user.index')->with('error', 'Failed to updated member!');
    }

    public function delete(User $user){
        return view('backend.user.user.delete', [
            'user' => $user
        ]);
    }

    public function destroy($id){
        if($this->userService->destroy($id)){
            return redirect()->route('user.index')->with('success', 'Deleted member successfully!');
        }

        return redirect()->route('user.index')->with('error', 'Failed to delete member!');
    }

}
