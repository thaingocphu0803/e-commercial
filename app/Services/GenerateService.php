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

            // $this->makeRoute();
            // $this->makeLang();
            $payload = $request->except(['_token']);

            // $this->generateRepository->create($payload);

            DB::commit();
            // $this->makeDatabase($request);
            // $this->makeController($request);
            // $this->makeModel($request);
            // $this->makeRule($request);
            // $this->makeRequest($request);
            // $this->makeRepository($request);
            // $this->makeService($request);
            $this->makeView($request);





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

    private function makeRequest($request)
    {
        try {
            $payload = $request->only('name', 'module_type');
            $moduleName = lcfirst($payload['name']);
            $ModuleName = ucfirst($payload['name']);
            $moduleTableName = $this->convertToTableName($moduleName);

            $fileRequestName = [
                "Store{$ModuleName}Request.php",
                "Update{$ModuleName}Request.php",
                "Delete{$ModuleName}Request.php",
            ];

            $fileTemplateName = [
                "StoreTemplateRequest.php",
                "UpdateTemplateRequest.php",
                "DeleteTemplateRequest.php",
            ];

            if ($payload['module_type'] != 1) {
                unset($fileRequestName[2]);
                unset($fileTemplateName[2]);
            }
            $option = [
                'ModuleName' => $ModuleName,
                'moduleTableName' => $moduleTableName,
            ];

            foreach ($fileRequestName as $key => $val) {
                $templatePath = base_path("app\\templates\\$fileTemplateName[$key]");
                $templateContent = file_get_contents($templatePath);

                if (empty($templateContent)) return false;

                $newContent = $this->replaceTemplateContent($option, $templateContent);
                $modulePath = base_path("app\\Http\\Requests\\$val");

                File::put($modulePath, $newContent);
            }
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function makeRule($request)
    {
        try {
            $payload = $request->only('name', 'module_type');
            if ($payload['module_type'] != 1) return false;
            $ModuleName = ucfirst($payload['name']);
            $templatepath = base_path("app\\templates\\TemplateRule.php");
            $templateContent = file_get_contents($templatepath);
            $option = [
                'ModuleName' => $ModuleName,
            ];

            $newContent = $this->replaceTemplateContent($option, $templateContent);
            $modulePath = base_path("app\\Rules\\Check{$ModuleName}ChildrenRule.php");

            File::put($modulePath, $newContent);
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function makeView($request)
    {
        try {
            $moduleName = lcfirst($request->input('name'));
            $moduleTableName = $this->convertToTableName($moduleName);
            $extractModule = explode('_', $moduleTableName);
            $baseViewPath = resource_path("views\\Backend\\$extractModule[0]");
            $baseComponentPath = resource_path("views\\components\\backend\\$extractModule[0]");
            $exactFolder = (count($extractModule) == 2) ? $extractModule[1] : $extractModule[0];
            $exactViewPath =  "$baseViewPath\\$exactFolder";
            $exactComponentPath = "$baseComponentPath\\$exactFolder";
            $routerPath = (count($extractModule) == 2) ? $extractModule[0] . '.' . $extractModule[1] : $extractModule[0];
            $module  = (count($extractModule) == 2) ? $extractModule[0] . 'Group' : $extractModule[0];
            // dd($this->makeDirectory($baseViewPath));
            if(!$this->makeDirectory($baseViewPath)) return false;
            if(!$this->makeDirectory($baseComponentPath)) return false;

            if(!$this->makeDirectory($exactViewPath)) return false;
            if(!$this->makeDirectory($exactComponentPath)) return false;

            $componentFile = [
                'filter.blade.php',
                'table.blade.php'
            ];

            $templateFile = [
                'create.blade.php',
                'delete.blade.php',
                'index.blade.php',
            ];

            $option = [
                'routerPath' => $routerPath,
                'module' => $module,
                'moduleName' => $moduleName,
                'moduleTableName' => $moduleTableName
            ];

            foreach ($componentFile as $fileName) {
                $templateComponentPath = base_path("app\\templates\\views\\component\\$fileName");
                $templateComponentContent  = file_get_contents($templateComponentPath);
                $newContent = $this->replaceTemplateContent($option, $templateComponentContent);

                if (File::exists($exactComponentPath)) {
                    $componentPath = "$exactComponentPath\\$fileName";
                    File::put($componentPath, $newContent);
                }
            }

            foreach ($templateFile as $fileName) {
                $templatePath = base_path("app\\templates\\views\\template\\$fileName");
                $templateContent  = file_get_contents($templatePath);
                $newContent = $this->replaceTemplateContent($option, $templateContent);

                if (File::exists($exactViewPath)) {
                    $viewPath = "$exactViewPath\\$fileName";
                    File::put($viewPath, $newContent);
                }
            }
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
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

            if ($pattern == 'Repository') {
                $insertAppProvider = "\t\"App\\Repositories\\Interfaces\\{$ModuleName}RepositoryInterface\" => \"App\\Repositories\\{$ModuleName}Repository\",\n\t";
                $providerPath = base_path('app\\Providers\\AppServiceProvider.php');
                $providerContent = file_get_contents($providerPath);
                $position =  strpos($providerContent, "];");
                if ($position === false) return false;

                $newProviderContent = substr_replace($providerContent, $insertAppProvider, $position, 0);
                File::put($providerPath, $newProviderContent);
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

    private function makeDirectory($path)
    {

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            return true;
        }
        return false;
    }
}
