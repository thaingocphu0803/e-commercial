<?php

namespace App\Services;

use App\Repositories\CustomerCatalougeRepository;
use App\Services\Interfaces\CustomerCatalougeServiceInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerCatalougeService
 * @package App\Services
 */
class CustomerCatalougeService implements CustomerCatalougeServiceInterface
{
    protected $customerCatalougeRepository;

    public function __construct(CustomerCatalougeRepository $customerCatalougeRepository)
    {
        $this->customerCatalougeRepository = $customerCatalougeRepository;
    }

    public function getAll()
    {
        $customerCatalouge = $this->customerCatalougeRepository->getAll();
        return $customerCatalouge;
    }

    public function paginate($request)
    {
        $customers = $this->customerCatalougeRepository->paginate($request);
        return $customers;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token']);

            $this->customerCatalougeRepository->create($payload);

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

            $this->customerCatalougeRepository->update($id, $payload);

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
            $this->customerCatalougeRepository->destroy($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }


    public function forceDestroy($id)
    {
        DB::beginTransaction();
        try {
            $this->customerCatalougeRepository->forceDestroy($id);

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
            $this->customerCatalougeRepository->updateStatus($payload);

            $this->customerCatalougeRepository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->customerCatalougeRepository->updateStatusAll($payload);
            $this->customerCatalougeRepository->updateByWhereIn($payload['ids'], $payload['value']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }
}
