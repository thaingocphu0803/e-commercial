<?php

namespace App\Services;

use App\Repositories\GenerateRepository;
use App\Services\Interfaces\GenerateServiceInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use NunoMaduro\Collision\Provider;

/**
 * Class GenerateService
 * @package App\Services
 */
class GenerateService implements GenerateServiceInterface
{
    protected $generateRepository;
    private const TEMPLATE_CATALOUGE = "TemplateCatalouge";
    private const TEMPLATE = "Template";
    private const SERVICE = "Service";
    private const REPOSITORY = "Repository";



    public function __construct(GenerateRepository $generateRepository)
    {
        $this->generateRepository = $generateRepository;
    }

    public function getAll()
    {
        $userCatalouge = $this->generateRepository->getAll();
        return $userCatalouge;
    }

    public function paginate($request)
    {
        $languages = $this->generateRepository->paginate($request);
        return $languages;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {

            // $this->makeProvider();
            // $this->makeRequest();
            // $this->makeView();
            // $this->makeRoute();
            // $this->makeRule();
            // $this->makeLang();
            $payload = $request->except(['_token']);

            // $this->generateRepository->create($payload);

            DB::commit();
            // $this->makeDatabase($request);
            // $this->makeController($request);
            // $this->makeModel($request);
            $this->makeRepository($request);
            // $this->makeService($request);




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

            $this->generateRepository->update($id, $payload);

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
            $this->generateRepository->destroy($id);

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
            $this->generateRepository->forceDestroy($id);

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
            $this->generateRepository->updateStatus($payload);

            // $this->generateRepository->updateByWhereIn($payload['modelId'], $payload['value']);


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
            $this->generateRepository->updateStatusAll($payload);
            // $this->generateRepository->updateByWhereIn($payload['ids'], $payload['value']);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    public function changeCurrent($canonical)
    {
        DB::beginTransaction();
        try {

            $this->generateRepository->changeCurrent($canonical);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    private function makeDatabase($request)
    {
        try {
            $payload = $request->only('name', 'schema', 'module_type');
            $name = lcfirst($payload['name']);
            $migrationTableName = $this->convertToTableName($name);
            $templatePath = base_path('app\\templates\\TemplateMigration.php');
            $templateContent = file_get_contents($templatePath);

            $option = [
                'schema' => $payload['schema'],
                'migrationTableName' => $migrationTableName
            ];

            $migrationFileName = date('Y_m_d_His') . '_create_' . $migrationTableName . 's_table.php';
            $migrationPath = database_path("migrations\\$migrationFileName");
            $newContent = $this->replaceTemplateContent($option, $templateContent);

            File::put($migrationPath, $newContent);

            if ($payload['module_type'] != 3) {
                $templatePivotPath = base_path('app\\templates\\TemplatePivotMigration.php');
                $templatePivotContent = file_get_contents($templatePivotPath);
                $newPivotContent = $this->replaceTemplateContent($option, $templatePivotContent);


                $migrationPivotFileName = date('Y_m_d_His', time() + 10) . '_create_' . $migrationTableName . '_language_table.php';
                $migrationPivotPath = database_path("migrations\\$migrationPivotFileName");

                File::put($migrationPivotPath, $newPivotContent);

                Artisan::call('migrate');
            }
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();

            return false;
        }
    }

    private function makeController($request)
    {
        $payload = $request->only('name', 'module_type');
        $name = lcfirst($payload['name']);

        switch ($payload['module_type']) {
            case 1:
                $this->createTemplateController($name, self::TEMPLATE_CATALOUGE);
                break;
            case 2:
                $this->createTemplateController($name, self::TEMPLATE);
                break;
            default:
                $this->createSingleController($name);
        }
    }

    private function makeModel($request)
    {
        $payload = $request->only('name', 'module_type');
        $name = lcfirst($payload['name']);

        switch ($payload['module_type']) {
            case 1:
                $this->createTemplateModel($name, self::TEMPLATE_CATALOUGE);
                break;
            case 2:
                $this->createTemplateModel($name, self::TEMPLATE);
                break;
            default:
                break;
        }
    }

    private function makeService($request)
    {
        $payload = $request->only('name', 'module_type');
        $name = lcfirst($payload['name']);

        switch ($payload['module_type']) {
            case 1:
                $this->createTemplatePattern($name, self::TEMPLATE_CATALOUGE, self::SERVICE);
                break;
            case 2:
                $this->createTemplatePattern($name, self::TEMPLATE, self::SERVICE);
                break;
            default:
                break;
        }
    }

    private function makeRepository($request)
    {
        $payload = $request->only('name', 'module_type');
        $name = lcfirst($payload['name']);

        switch ($payload['module_type']) {
            case 1:
                $this->createTemplatePattern($name, self::TEMPLATE_CATALOUGE, self::REPOSITORY);
                break;
            case 2:
                $this->createTemplatePattern($name, self::TEMPLATE, self::REPOSITORY);
                break;
            default:
                break;
        }
    }

    private function createTemplateController($name, $templateName)
    {
        try {
            $ModuleTemplate = ucfirst($name);
            $moduleTemplate = $name;
            $moduleView = $this->converToViewFolder($name);

            $templatePath = base_path('app\\templates\\' . $templateName . 'Controller.php');
            $templateContent = file_get_contents($templatePath);

            $option = [
                'ModuleTemplate' => $ModuleTemplate,
                'moduleTemplate' => $moduleTemplate,
                'moduleView' => $moduleView
            ];
            $newContent = $this->replaceTemplateContent($option, $templateContent);
            $controllerPath = base_path('app\\Http\\Controllers\\Backend\\' . $ModuleTemplate . 'Controller.php');

            File::put($controllerPath, $newContent);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function createSingleController($name) {}

    private function  createTemplateModel($name, $templateName)
    {

        try {
            $moduleTable  = $this->convertToTableName($name);
            $ModuleTemplate = ucfirst($name);
            $moduleTemplate = $name;
            $relation = explode('_', $moduleTable)[0];
            $relationModel = ucfirst($relation);

            $templatePath =  base_path('app\\templates\\' . $templateName . 'Model.php');
            $templateContent = file_get_contents($templatePath);

            $option = [
                'moduleTable' => $moduleTable,
                'ModuleTemplate' => $ModuleTemplate,
                'moduleTemplate' => $moduleTemplate,
                'relation' => $relation,
                'relationModel' => $relationModel
            ];

            $newContent = $this->replaceTemplateContent($option, $templateContent);
            $modelPath = base_path('app\\Models\\' . $ModuleTemplate . '.php');

            File::put($modelPath, $newContent);
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }
    private function createTemplatePattern($name, $templateName, $pattern)
    {
        try {
            $templateInterfacePath = base_path('app\\templates\\' . $templateName . $pattern . 'Interface.php');
            $templatePath = base_path('app\\templates\\' . $templateName . $pattern . '.php');
            $folderPattern = ($pattern == 'Repository') ? 'Repositories' : 'Services';

            $templateInterfaceContent = file_get_contents($templateInterfacePath);
            if (!$templateInterfaceContent) return false;

            $templateContent = file_get_contents($templatePath);
            if (!$templateContent) return false;

            $ModuleName = ucfirst($name);
            $moduleTableName  = $this->convertToTableName($name);

            $option = [
                'ModuleName' => $ModuleName,
                'moduleName' => $name,
                'moduleTableName' => $moduleTableName
            ];

            $newInterfaceContent = $this->replaceTemplateContent($option, $templateInterfaceContent);
            $newContent = $this->replaceTemplateContent($option, $templateContent);

            $patternInterfacePath = base_path('app\\' . $folderPattern . '\\Interfaces\\' . $ModuleName . $pattern . 'Interface.php');
            $patternPath = base_path('app\\' . $folderPattern . '\\' . $ModuleName . $pattern . '.php');

            $putPatternInterFace = File::put($patternInterfacePath, $newInterfaceContent);

            if (!$putPatternInterFace) return false;

            $putPattern = File::put($patternPath, $newContent);

            if (!$putPattern) return false;

            if($pattern == 'Repository'){
                $insertAppProvider =  "'App\Repositories\Interfaces\'.$ModuleName.'RepositoryInterface' => 'App\Repositories\'.$ModuleName.'Repository'";
                $providerPath = base_path('app\\Provides\\AppServiceProvider.php');
                $providerContent = file_get_contents($providerPath);
                dd($providerContent);
            }

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function convertToTableName($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        return $temp;
    }

    private function converToViewFolder($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '.$0', $name));
        return $temp;
    }

    private function replaceTemplateContent($dataArray, $templateContent)
    {
        foreach ($dataArray as $key => $val) {
            $templateContent = str_replace('{' . $key . '}', $val, $templateContent);
        }

        return $templateContent;
    }
}
