<?php

namespace App\Services;

use App\Repositories\GenerateRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\UserCatalougeRepository;
use App\Services\Interfaces\GenerateServiceInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Class GenerateService
 * @package App\Services
 */
class GenerateService implements GenerateServiceInterface
{
    protected $generateRepository;
    protected $permissionRepository;
    protected $userCatalougeRepository;
    private const TEMPLATE_CATALOUGE = "TemplateCatalouge";
    private const TEMPLATE = "Template";
    private const SERVICE = "Service";
    private const REPOSITORY = "Repository";



    public function __construct(
        GenerateRepository $generateRepository,
        PermissionRepository $permissionRepository,
        UserCatalougeRepository $userCatalougeRepository
    ) {
        $this->generateRepository = $generateRepository;
        $this->permissionRepository = $permissionRepository;
        $this->userCatalougeRepository = $userCatalougeRepository;
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
            $payload = $request->except(['_token']);

            // $this->insertPermission($request);
            // $this->generateRepository->create($payload);
            DB::commit();

            $this->makeDatabase($request);
            // $this->makeModel($request);
            // $this->makeRule($request);
            // $this->makeRequest($request);
            // $this->makeRepository($request);
            // $this->makeService($request);
            // $this->makeController($request);
            // $this->makeRoute($request);
            // $this->makeView($request);
            // $this->makeNavModule($request);

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
            $payload = $request->only('name', 'schema_detail', 'schema_catalouge', 'module_type');
            $moduleName = $this->convertToDashBetween($payload['name']);
            $tableCatalougeName = $moduleName . '_catalouge';
            $schemaPath = base_path('app\\templates\\migrations\\schema.php');
            $shemaContent = file_get_contents($schemaPath);

            $optionCatalouge = [
                'schema' => $payload['schema_catalouge'],
                'tableName' => $tableCatalougeName
            ];

            $catalougeFile = date('Y_m_d_His') . '_create_' . $optionCatalouge['tableName'] . 's_table.php';
            $catalougeMigration  = $this->createMigration($optionCatalouge, $shemaContent, $catalougeFile);
            if (!$catalougeMigration) return false;

            $optionDetail = [
                'schema' => $payload['schema_detail'],
                'tableName' => $moduleName,
                'moduleName' => $moduleName,

            ];

            $shemaContent = str_replace('//@', '', $shemaContent);
            $detailFile = date('Y_m_d_His', time() + 10) . '_create_' . $optionDetail['tableName'] . 's_table.php';
            $detailMigration  = $this->createMigration($optionDetail, $shemaContent, $detailFile);
            if (!$detailMigration) return false;

            $pivotLanguagepath = base_path('app\\templates\\migrations\\pivotLanguage.php');
            $pivotLanguageContent = file_get_contents($pivotLanguagepath);

            $pivotLanguageCFile = date('Y_m_d_His', time() + 20) . '_create_' . $optionCatalouge['tableName'] . '_language_table.php';
            $pivotLanguageCMigration = $this->createMigration($optionCatalouge, $pivotLanguageContent, $pivotLanguageCFile);
            if (!$pivotLanguageCMigration) return false;

            $pivotLanguageDFile = date('Y_m_d_His', time() + 30) . '_create_' . $optionCatalouge['tableName'] . '_language_table.php';
            $pivotLanguageDMigration = $this->createMigration($optionDetail, $pivotLanguageContent, $pivotLanguageDFile);
            if (!$pivotLanguageDMigration) return false;


            $pivotModulePath = base_path('app\\templates\\migrations\\pivotModule.php');
            $pivotModuleContent = file_get_contents($pivotModulePath);
            $pivotModuleFile = date('Y_m_d_His', time() + 40) . '_create_' . $optionCatalouge['tableName'] . '_' . $optionDetail['tableName'] . '_table.php';
            $pivotModuleMigration = $this->createMigration($optionDetail, $pivotModuleContent, $pivotModuleFile);
            if (!$pivotModuleMigration) return false;

            Artisan::call('migrate');

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
            $moduleTableName = $this->convertToDashBetween($moduleName);

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
            $moduleType = $request->input('module_type');
            $moduleName = lcfirst($request->input('name'));
            $moduleTableName = $this->convertToDashBetween($moduleName);
            $extractModule = explode('_', $moduleTableName);
            $baseViewPath = resource_path("views\\Backend\\$extractModule[0]");
            $baseComponentPath = resource_path("views\\components\\backend\\$extractModule[0]");
            $exactFolder = (count($extractModule) == 2) ? $extractModule[1] : $extractModule[0];
            $exactViewPath =  "$baseViewPath\\$exactFolder";
            $exactComponentPath = "$baseComponentPath\\$exactFolder";
            $routerPath = (count($extractModule) == 2) ? $extractModule[0] . '.' . $extractModule[1] : $extractModule[0];
            $componentPath = (count($extractModule) == 2) ? $extractModule[0] . '.' . $extractModule[1] : $extractModule[0] . "." . $extractModule[0];

            $module  = (count($extractModule) == 2) ? $extractModule[0] . 'Group' : $extractModule[0];

            if (!$this->makeDirectory($baseViewPath)) return false;

            if (!$this->makeDirectory($baseComponentPath)) return false;

            if (!$this->makeDirectory($exactViewPath)) return false;
            if (!$this->makeDirectory($exactComponentPath)) return false;


            $componentFile = [
                'filter.blade.php',
                'table.blade.php'
            ];

            $templateFile = [
                'create.blade.php',
                'delete.blade.php',
                'index.blade.php',
            ];

            if ($moduleType == 2) {
                $templateFile[0] = 'createdetail.blade.php';
            }

            $option = [
                'routerPath' => $routerPath,
                'componentPath' => $componentPath,
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
                if ($fileName == 'createdetail.blade.php') {
                    $fileName = 'create.blade.php';
                }
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

    private function makeRoute($request)
    {

        try {
            $name = $request->input('name');
            $ModuleName = ucfirst($name);
            $moduleRouterName = $this->convertToSlashBetween($name);
            $moduleViewName = $this->convertToPeriodBetween($name);

            $templatePath = base_path('app\\templates\\TemplateRouter.php');
            $templateContent = file_get_contents($templatePath);
            $option = [
                'ModuleName' => $ModuleName,
                'moduleRouterName' => $moduleRouterName,
                'moduleViewName' => $moduleViewName
            ];
            $newTemplateContent = $this->replaceTemplateContent($option, $templateContent);
            $useController = 'use App\\Http\\Controllers\\Backend\\' . $ModuleName . 'Controller;' . "\n";
            $routerPath = base_path('routes\\web.php');
            $routerContent = file_get_contents($routerPath);
            $useControllerPosition = strpos($routerContent, '//@use-controller@');

            $newControllerContent  = $this->insertFile($routerContent, $routerPath, $useController, $useControllerPosition);

            if ($newControllerContent) {
                $newModulePosition =  strpos($newControllerContent, '//@new-module@');
                $putRouter  = $this->insertFile($newControllerContent, $routerPath, $newTemplateContent, $newModulePosition);
                if (!$putRouter) return false;
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
            $moduleView = $this->convertToPeriodBetween($name);

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
            $moduleTable  = $this->convertToDashBetween($name);
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
            $moduleTableName  = $this->convertToDashBetween($name);

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

                $newContent = $this->insertFile($providerContent, $providerPath, $insertAppProvider, $position);
                if (!$newContent) return false;
            }

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function convertToDashBetween($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        return $temp;
    }

    private function convertToPeriodBetween($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '.$0', $name));
        return $temp;
    }

    private function convertToSlashBetween($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '/$0', $name));
        return $temp;
    }

    private function convertToSpaceBetween($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', ' $0', $name));
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
            if (!File::makeDirectory($path, 0755, true)) return false;
        }
        return true;
    }

    private function insertFile($content, $path, $insertLine, $position)
    {
        $newProviderContent = substr_replace($content, $insertLine, $position, 0);

        if (!File::put($path, $newProviderContent)) return false;

        return $newProviderContent;
    }

    private function insertPermission($request)
    {
        $name = lcfirst($request->input('name'));
        $module  = $this->convertToSpaceBetween($name);
        $canonical = $this->convertToPeriodBetween($name);
        $namePermission = [
            "Xem danh sách $module",
            "Tạo $module",
            "Sửa $module",
            "Xóa $module"
        ];

        $canonicalPermission = [
            "$canonical.index",
            "$canonical.create",
            "$canonical.update",
            "$canonical.delete",
        ];

        $payloadPermission = [];

        foreach ($namePermission as $key => $val) {
            $payload = [
                'name' => $val,
                'canonical' => $canonicalPermission[$key]
            ];

            $permission = $this->permissionRepository->create($payload);
            if ($permission->id) {
                $payloadPermission[] = $permission->id;
            }
        }
        $updatePermisison = $this->updateUserPermission($payloadPermission);
        if (!$updatePermisison) return false;
        return true;
    }

    private function makeNavModule($request)
    {
        $name = lcfirst($request->input('name'));
        $name = $this->convertToDashBetween($name);
        $moduleIcon = $request->input('module_icon');
        $moduleName = explode('_', $name)[0];
        $templatePath = base_path('app\\templates\\views\\component\\module.blade.php');
        $templateContent = file_get_contents($templatePath);
        $option = [
            'moduleName' => $moduleName,
            'moduleIcon' => $moduleIcon
        ];

        $newContent = $this->replaceTemplateContent($option, $templateContent);
        $this->insertToNavView($newContent, $moduleName);
    }

    private function insertToNavView($insertContent, $moduleName)
    {
        try {

            $navPath = resource_path('views\\components\\backend\\dashboard\\nav.blade.php');
            $navContent = file_get_contents($navPath);
            $modulePosition = strpos($navContent, "dashboard.$moduleName");
            if (!$modulePosition) {
                $insertPosition = strpos($navContent, '{{-- @new-module --}}');
                $newContent = $this->insertFile($navContent, $navPath, $insertContent, $insertPosition);
                if (!$newContent) return false;
            }
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }
    private function updateUserPermission($payload)
    {
        try {
            $userCatalougeId = Auth::user()->userCatalouge->id;
            $this->userCatalougeRepository->attachPermission($userCatalougeId, $payload);
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    private function createMigration($option, $template, $fileName)
    {
        $path = database_path("migrations\\$fileName");
        $newContent = $this->replaceTemplateContent($option, $template);

        if (!File::put($path, $newContent)) return false;

        return $newContent;
    }
}
