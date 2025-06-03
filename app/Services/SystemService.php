<?php

namespace App\Services;

use App\Repositories\SystemRepository;
use App\Services\Interfaces\SystemServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class SystemService
 * @package App\Services
 */
class SystemService implements SystemServiceInterface
{
    private $systemRepository;
    public function __construct(SystemRepository $systemRepository)
    {
        $this->systemRepository = $systemRepository;
    }
    public function create($request, $language_id)
    {

        $configs = $request->except(['_token']);
        $payload['language_id'] = $language_id;

        foreach($configs as $key => $val){
            $payload = [
                'keyword' => $key,
                'content' => $val,
                'language_id' => $language_id,
                'user_id' => Auth::id()
            ];

            $condition = ['keyword' => $key];

            $this->systemRepository->updateOrInsert($payload, $condition);
        }

        DB::beginTransaction();

        try {

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
            return false;
        }
    }

    public function all(){
        $systemConfig =  $this->systemRepository->getAll();
        return $systemConfig;
    }
}
