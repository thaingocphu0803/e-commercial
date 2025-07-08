<?php

namespace App\Services;

use App\Repositories\PermissionRepository;
use App\Services\Interfaces\PermissionServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionService
 * @package App\Services
 */
class PermissionService implements PermissionServiceInterface
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAll()
    {
        $permissions = $this->permissionRepository->getAll();
        return $permissions;
    }

    public function paginate($request)
    {
        $permissions = $this->permissionRepository->paginate($request);
        return $permissions;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token']);
            $this->permissionRepository->create($payload);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token']);

            $this->permissionRepository->update($id, $payload);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->permissionRepository->destroy($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function updateStatus($payload)
    {


        DB::beginTransaction();
        try {
            $this->permissionRepository->updateStatus($payload);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function updateStatusAll($payload)
    {

        DB::beginTransaction();
        try {
            $this->permissionRepository->updateStatusAll($payload);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }
}
