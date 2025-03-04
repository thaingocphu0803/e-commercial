<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalougeRequest;
use App\Http\Requests\UpdateUserCatalougeRequest;
use App\Models\UserCatalouge;
use App\Services\UserCatalougeService;
use Illuminate\Http\Request;

class UserCatalougeController extends Controller
{
    protected $userCatalougeService;

    public function __construct(
        UserCatalougeService $userCatalougeService,
        )
    {
        $this->userCatalougeService = $userCatalougeService;
    }

    public function index(Request $request){
        $userCatalouges = $this->userCatalougeService->paginate($request);
        return view('Backend.user.catalouge.index', [
            'userCatalouges' => $userCatalouges
        ]);
    }

    public function create(){
        return view('Backend.user.catalouge.create');
    }

    public function store(StoreUserCatalougeRequest $request){
        if($this->userCatalougeService->create($request)){
            return redirect()->route('user.catalouge.index')->with('success', __('alert.addSuccess', ['attribute'=> __('dashboard.memberGroup')]));
        }
        return redirect()->route('user.catalouge.index')->with('error', __('alert.addError', ['attribute'=> __('dashboard.memberGroup')]));
    }

    public function edit(UserCatalouge $userCatalouge){
        return view('backend.user.catalouge.create', [
            'userCatalouge' => $userCatalouge
        ]);
    }

    public function update($id, UpdateUserCatalougeRequest $request){

        if($this->userCatalougeService->update($id, $request)){
            return redirect()->route('user.catalouge.index')->with('success', __('alert.updateSuccess', ['attribute'=> __('dashboard.memberGroup')]));
        }

        return redirect()->route('user.catalouge.index')->with('error', __('alert.updateError', ['attribute'=> __('dashboard.memberGroup')]));
    }

    public function delete(UserCatalouge $userCatalouge){
        return view('backend.user.catalouge.delete', [
            'userCatalouge' => $userCatalouge
        ]);
    }

    public function destroy($id){
        if($this->userCatalougeService->destroy($id)){
            return redirect()->route('user.catalouge.index')->with('success', __('alert.deleteSuccess', ['attribute'=> __('dashboard.memberGroup')]));
        }

        return redirect()->route('user.catalouge.index')->with('error', __('alert.deleteError', ['attribute'=> __('dashboard.memberGroup')]));
    }

}
