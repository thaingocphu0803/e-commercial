<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\SourceRepository;
use App\Services\Interfaces\SourceServiceInterface;

/**
 * Class postService
 * @package App\Services
 */
class SourceService implements SourceServiceInterface
{
    protected   $sourceRepository;

    public function __construct(SourceRepository $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    public function getAll()
    {
        $sources = $this->sourceRepository->getAll();
        return $sources;
    }

    public function paginate($request)
    {
        $sources = $this->sourceRepository->paginate($request);
        return $sources;
    }

    public function findById($id)
    {
        $source = $this->sourceRepository->findById($id);

        return $source;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except('_token');
            $this->sourceRepository->create($payload);
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
            $payload = $request->except('_token');
            $this->sourceRepository->update($id, $payload);
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
            $this->sourceRepository->destroy($id);

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
            $this->sourceRepository->forceDestroy($id);

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
            $this->sourceRepository->updateStatus($payload);
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
            $this->sourceRepository->updateStatusAll($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }
}
