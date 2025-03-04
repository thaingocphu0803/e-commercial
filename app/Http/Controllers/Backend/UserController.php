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
            return redirect()->route('user.index')->with('success', __('alert.addSuccess', ['attribute'=> __('dashboard.member')]));
        }

        return redirect()->route('user.index')->with('error', __('alert.addError', ['attribute'=> __('dashboard.member')]));
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
            return redirect()->route('user.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('dashboard.member')]));
        }

        return redirect()->route('user.index')->with('error', __('alert.updateError', ['attribute'=> __('dashboard.member')]));
    }

    public function delete(User $user){
        return view('backend.user.user.delete', [
            'user' => $user
        ]);
    }

    public function destroy($id){
        if($this->userService->destroy($id)){
            return redirect()->route('user.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('dashboard.member')]));
        }

        return redirect()->route('user.index')->with('error', __('alert.deleteError', ['attribute'=> __('dashboard.member')]));
    }

}
