<?php

namespace App\Services;

use App\Repositories\SlideRepository;
use App\Services\Interfaces\SlideServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\json;

/**
 * Class SlideService
 * @package App\Services
 */
class SlideService implements SlideServiceInterface
{
    protected $slideRepository;

    public function __construct(SlideRepository $slideRepository)
    {
        $this->slideRepository = $slideRepository;
    }

    public function paginate($request)
    {
        $users = $this->slideRepository->paginate($request);
        return $users;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'slides']);
            $payload['settings']['arrow'] = $payload['settings']['arrow'] ?? 'unaccept';
            $payload['settings']['autoplay'] = $payload['settings']['autoplay'] ?? 'unaccept';
            $payload['settings']['pauseHover'] = $payload['settings']['pauseHover'] ?? 'unaccept';
            $payload['settings'] = json_encode($payload['settings']);
            $payload['item'] = $this->handleSlideItem($request->only(['slides']));
            $payload['user_id'] = Auth::id();
            $this->slideRepository->create($payload);

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
            $payload = $request->except(['_token', 'slides']);
            $payload['settings']['arrow'] = $payload['settings']['arrow'] ?? 'unaccept';
            $payload['settings']['autoplay'] = $payload['settings']['autoplay'] ?? 'unaccept';
            $payload['settings']['pauseHover'] = $payload['settings']['pauseHover'] ?? 'unaccept';
            $payload['settings'] = json_encode($payload['settings']);
            $payload['item'] = $this->handleSlideItem($request->only(['slides']));
            $payload['user_id'] = Auth::id();
            $this->slideRepository->update($id, $payload);

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
            $this->slideRepository->destroy($id);

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
            $this->slideRepository->forceDestroy($id);

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
            $this->slideRepository->updateStatus($payload);

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
            $this->slideRepository->updateStatusAll($payload);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    private function handleSlideItem($item)
    {
        $temp = [];
        foreach ($item['slides'] as $key => $val) {
            $temp[$key] = $val ?? NUll;
        }
        return json_encode($temp);
    }
}
