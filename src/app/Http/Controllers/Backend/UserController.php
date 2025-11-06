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
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('modules', 'user.index');
        $users = $this->userService->paginate($request);

        $userCatalouges = $this->userCatalougeService->getAll();


        return view('Backend.user.user.index', [
            'users' => $users,
            'groupMember' => $userCatalouges
        ]);
    }

    public function create(){
        Gate::authorize('modules', 'user.create');
        $provinces = $this->provinceRepository->getAll();
        $userCatalouges = $this->userCatalougeService->getAll();

        return view('Backend.user.user.create', [
            'provinces' => $provinces,
            'groupMember' => $userCatalouges
        ]);
    }

    public function store(StoreUserRequest $request){
        Gate::authorize('modules', 'user.create');
        if($this->userService->create($request)){
            return redirect()->route('user.index')->with('success', __('alert.addSuccess', ['attribute'=> __('custom.member')]));
        }

        return redirect()->route('user.index')->with('error', __('alert.addError', ['attribute'=> __('custom.member')]));
    }

    public function edit(User $user){
        Gate::authorize('modules', 'user.update');
        $provinces = $this->provinceRepository->getAll();
        $userCatalouges = $this->userCatalougeService->getAll();

        return view('backend.user.user.create', [
            'groupMember' => $userCatalouges,
            'provinces' => $provinces,
            'user' => $user
        ]);
    }

    public function update($id, UpdateUserRequest $request){
        Gate::authorize('modules', 'user.update');
        if($this->userService->update($id, $request)){
            return redirect()->route('user.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('custom.member')]));
        }

        return redirect()->route('user.index')->with('error', __('alert.updateError', ['attribute'=> __('custom.member')]));
    }

    public function delete(User $user){
        Gate::authorize('modules', 'user.delete');
        return view('backend.user.user.delete', [
            'user' => $user
        ]);
    }

    public function destroy($id){
        Gate::authorize('modules', 'user.delete');
        if($this->userService->destroy($id)){
            return redirect()->route('user.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('custom.member')]));
        }

        return redirect()->route('user.index')->with('error', __('alert.deleteError', ['attribute'=> __('custom.member')]));
    }

}
