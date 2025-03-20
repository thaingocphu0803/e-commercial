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
    private const TEMPLATE_CATALOUGE = "moduleCatalouge";
    private const TEMPLATE = "module";
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
            $this->insertPermission($request);
            $this->generateRepository->create($payload);
            DB::commit();

            $this->makeDatabase($request);
            $this->makeModel($request);
            $this->makeRule($request);
            $this->makeRequest($request);
            $this->makeRepository($request);
            $this->makeService($request);
            $this->makeController($request);
            $this->makeRoute($request);
            $this->makeView($request);
            $this->makeNavModule($request);

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
            $moduleName = lcfirst($payload['name']);
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

    private function makeModel($request)
    {
        try {
            $moduleName = lcfirst($request->input('name'));
            $moduleCatalougeName = $moduleName . 'Catalouge';
            $tableCatalougeName = $moduleName . '_catalouge';

            $option = [
                'moduleName' => $moduleName,
                'ModuleName' => ucfirst($moduleName),
                'ModuleCatalougeName' => ucfirst($moduleCatalougeName),
                'moduleCatalougeName' => $moduleCatalougeName,
                'tableCatalougeName' => $tableCatalougeName

            ];

            $catalougePath =  base_path('app\\templates\\models\\moduleCatalouge.php');
            $modelCatalougePath = base_path('app\\Models\\' . $option['ModuleCatalougeName'] . '.php');
            $this->createFile($option, $catalougePath, $modelCatalougePath);


            $modulePath = base_path('app\\templates\\models\\module.php');
            $modelModulePath =  base_path('app\\Models\\' . $option['ModuleName'] . '.php');
            $this->createFile($option, $modulePath, $modelModulePath);


            $catalougeLanguagePath =  base_path('app\\templates\\models\\moduleCatalougeLanguage.php');
            $modelCatalougeLanguagePath = base_path('app\\Models\\' . $option['ModuleCatalougeName'] . 'Language.php');
            $this->createFile($option, $catalougeLanguagePath, $modelCatalougeLanguagePath);

            $moduleLanguagePath =  base_path('app\\templates\\models\\moduleLanguage.php');
            $modelModuleLanguagePath = base_path('app\\Models\\' . $option['ModuleName'] . 'Language.php');
            $this->createFile($option, $moduleLanguagePath, $modelModuleLanguagePath);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function makeRule($request)
    {
        try {
            $ModuleName = ucfirst($request->input('name'));
            $option = [
                'ModuleCatalougeName' => $ModuleName . 'Catalouge',
            ];
            $templatepath = base_path("app\\templates\\rules\\moduleChildrenRule.php");
            $modulePath = base_path("app\\Rules\\Check{$ModuleName}ChildrenRule.php");
            $this->createFile($option, $templatepath, $modulePath);
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function makeRequest($request)
    {
        try {
            $moduleName = lcfirst($request->input('name'));
            $ModuleName = ucfirst($request->input('name'));


            $optionModule = [
                'ModuleName' => $ModuleName,
                'moduleTableName' => $moduleName,
            ];

            $optionCatalouge = [
                'ModuleName' => $ModuleName . 'Catalouge',
                'moduleTableName' => $moduleName . '_catalouge',
            ];

            $fileRequestName = [
                "Store{$ModuleName}Request.php",
                "Update{$ModuleName}Request.php",
            ];

            $fileCatalougeRequestName = [
                "Store{$ModuleName}CatalougeRequest.php",
                "Update{$ModuleName}CatalougeRequest.php",
                "Delete{$ModuleName}CatalougeRequest.php",
            ];

            $fileTemplateName = [
                "StoreTemplateRequest.php",
                "UpdateTemplateRequest.php",
                "DeleteTemplateRequest.php",
            ];

            foreach ($fileRequestName as $key => $val) {
                $templatePath = base_path("app\\templates\\requests\\$fileTemplateName[$key]");
                $modulePath = base_path("app\\Http\\Requests\\$val");
                $this->createFile($optionModule, $templatePath, $modulePath);
            }

            foreach ($fileCatalougeRequestName as $key => $val) {
                $templatePath = base_path("app\\templates\\requests\\$fileTemplateName[$key]");
                $modulePath = base_path("app\\Http\\Requests\\$val");
                $this->createFile($optionCatalouge, $templatePath, $modulePath);
            }
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function makeRepository($request)
    {
        $moduleName = lcfirst($request->input('name'));
        $moduleCatalougeName = $moduleName . 'Catalouge';

        $this->createTemplatePattern($moduleCatalougeName, self::TEMPLATE_CATALOUGE, self::REPOSITORY);
        $this->createTemplatePattern($moduleName, self::TEMPLATE, self::REPOSITORY);
    }

    private function makeService($request)
    {
        $moduleName = lcfirst($request->input('name'));
        $moduleCatalougeName = $moduleName . 'Catalouge';

        $this->createTemplatePattern($moduleCatalougeName, self::TEMPLATE_CATALOUGE, self::SERVICE);
        $this->createTemplatePattern($moduleName, self::TEMPLATE, self::SERVICE);
    }

    private function makeController($request)
    {
        $moduleName = lcfirst($request->input('name'));
        $moduleCatalougeName = $moduleName.'Catalouge';
        $this->createTemplateController($moduleCatalougeName, self::TEMPLATE_CATALOUGE);
        $this->createTemplateController($moduleName, self::TEMPLATE);
    }

    private function makeView($request)
    {
        try {
            $moduleName = lcfirst($request->input('name'));
            //base module path
            $baseViewPath = resource_path("views\\Backend\\$moduleName");
            $baseComponentPath = resource_path("views\\components\\backend\\$moduleName");
            //view module path
            $viewModulePath =  "$baseViewPath\\$moduleName";
            $viewCatalougePath =  "$baseViewPath\\catalouge";
            //component path
            $moduleComponentPath = "$baseComponentPath\\$moduleName";
            $catalougeComponentPath =  "$baseComponentPath\\catalouge";
            //component tag
            $catalougeComponentTag = $moduleName.'.catalouge';
            $moduleComponentTag = $moduleName . "." . $moduleName;

            if (!$this->makeDirectory($baseViewPath)) return false;
            if (!$this->makeDirectory($baseComponentPath)) return false;
            if (!$this->makeDirectory($viewModulePath)) return false;
            if (!$this->makeDirectory($viewCatalougePath)) return false;
            if (!$this->makeDirectory($moduleComponentPath)) return false;
            if (!$this->makeDirectory($catalougeComponentPath)) return false;

            $optionModule = [
                'routerPath' => $moduleName,
                'componentPath' => $moduleComponentTag,
                'module' => $moduleName,
                'moduleName' => $moduleName,
                'moduleTableName' => $moduleName
            ];

            $optionCatalouge = [
                'routerPath' => $catalougeComponentTag,
                'componentPath' => $catalougeComponentTag,
                'module' => $moduleName.'Group',
                'moduleName' => $moduleName.'Catalouge',
                'moduleTableName' => $moduleName.'_catalouge'
            ];

            $this->createModuleComponent($optionModule, $moduleComponentPath);
            $this->createModuleView($optionModule, $viewModulePath);
            $this->createModuleComponent($optionCatalouge, $catalougeComponentPath);
            $this->createModuleView($optionCatalouge, $viewCatalougePath);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function makeRoute($request)
    {

        try {
            $moduleName = $request->input('name');
            $ModuleName = ucfirst($moduleName);
            $templatePath = base_path('app\\templates\\routes\\moduleRouter.php');
            $templateContent = file_get_contents($templatePath);
            $optionModule = [
                'ModuleName' => $ModuleName,
                'moduleRouterName' => $moduleName,
                'moduleViewName' => $moduleName
            ];

            $newTemplateContent = $this->replaceTemplateContent($optionModule, $templateContent);
            $useController = 'use App\\Http\\Controllers\\Backend\\' . $optionModule['ModuleName'] . 'Controller;' . "\n";
            $routerPath = base_path('routes\\web.php');
            $routerContent = file_get_contents($routerPath);
            $useControllerPosition = strpos($routerContent, '//@use-controller@');

            $newControllerContent  = $this->insertFile($routerContent, $routerPath, $useController, $useControllerPosition);

            if ($newControllerContent) {
                $newModulePosition =  strpos($newControllerContent, '//@new-module@');
                $putRouter  = $this->insertFile($newControllerContent, $routerPath, $newTemplateContent, $newModulePosition);

                if (!$putRouter) return false;

                $optionCatalouge = [
                    'ModuleName' => $ModuleName. 'Catalouge',
                    'moduleRouterName' => $moduleName.'/catalouge',
                    'moduleViewName' => $moduleName.'.catalouge'
                ];

                $useCatalougeController = 'use App\\Http\\Controllers\\Backend\\' . $optionCatalouge['ModuleName'] . 'Controller;' . "\n";
                $useCatalougeControllerPosition = strpos($putRouter, '//@use-controller@');
                $newControllerContent  = $this->insertFile($putRouter, $routerPath, $useCatalougeController, $useCatalougeControllerPosition);

                if($newControllerContent){
                    $newTemplateContent = $this->replaceTemplateContent($optionCatalouge, $templateContent);
                    $newModulePosition =  strpos($newControllerContent, '//@new-module@');
                    $putRouter  = $this->insertFile($newControllerContent, $routerPath, $newTemplateContent, $newModulePosition);
                    if (!$putRouter) return false;
                }

            }

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function createModuleComponent($option, $path)
    {
        $componentFile = [
            'filter.blade.php',
            'table.blade.php'
        ];

        foreach ($componentFile as $fileName) {
            $templateComponentPath = base_path("app\\templates\\views\\component\\$fileName");
            $templateComponentContent  = file_get_contents($templateComponentPath);
            $newContent = $this->replaceTemplateContent($option, $templateComponentContent);

            if (File::exists($path)) {
                $componentPath = "$path\\$fileName";
                if(!File::put($componentPath, $newContent)) return false;
            }
        }

        return true;
    }

    private function createModuleView($option, $path)
    {
        $templateFile = [
            'create.blade.php',
            'delete.blade.php',
            'index.blade.php',
        ];

        $extraRoutePath = explode('.',$option['routerPath']);

        (count($extraRoutePath) > 1) && $templateFile[0] = 'createdetail.blade.php';

        foreach ($templateFile as $fileName) {
            $templatePath = base_path("app\\templates\\views\\template\\$fileName");
            $templateContent  = file_get_contents($templatePath);
            $newContent = $this->replaceTemplateContent($option, $templateContent);

            if (File::exists($path)) {
                ($fileName == 'createdetail.blade.php') && $fileName = 'create.blade.php';
                $viewPath = "$path\\$fileName";
                if(!File::put($viewPath, $newContent)) return false;
            }
        }

        return true;
    }

    private function createTemplateController($name, $templateName)
    {
        try {
            $ModuleTemplate = ucfirst($name);
            $moduleTemplate = $name;
            $moduleView = $this->convertToPeriodBetween($name);

            $option = [
                'ModuleTemplate' => $ModuleTemplate,
                'moduleTemplate' => $moduleTemplate,
                'moduleView' => $moduleView
            ];

            $templatePath = base_path('app\\templates\\controllers\\' . $templateName . 'Controller.php');
            $controllerPath = base_path('app\\Http\\Controllers\\Backend\\' . $ModuleTemplate . 'Controller.php');
            $this->createFile($option, $templatePath, $controllerPath);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }

    private function createTemplatePattern($name, $templateName, $pattern)
    {
        try {
            $folderPattern = ($pattern == 'Repository') ? 'repositories' : 'services';
            $ModuleName = ucfirst($name);
            $moduleTableName  = $this->convertToDashBetween($name);

            $option = [
                'ModuleName' => $ModuleName,
                'moduleName' => $name,
                'moduleTableName' => $moduleTableName
            ];
            $templateInterfacePath = base_path('app\\templates\\' . $folderPattern . '\\interfaces\\' . $templateName . $pattern . 'Interface.php');
            $patternInterfacePath = base_path('app\\' . $folderPattern . '\\Interfaces\\' . $ModuleName . $pattern . 'Interface.php');
            $this->createFile($option, $templateInterfacePath, $patternInterfacePath);

            $templatePath = base_path('app\\templates\\' . $folderPattern . '\\' . $templateName . $pattern . '.php');
            $patternPath = base_path('app\\' . $folderPattern . '\\' . $ModuleName . $pattern . '.php');
            $this->createFile($option, $templatePath, $patternPath);

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
        $module = lcfirst($request->input('name'));
        $namePermission = [
            "Xem danh sách $module",
            "Tạo $module",
            "Sửa $module",
            "Xóa $module",
            "Xem danh sách Nhóm $module",
            "Tạo Nhóm $module",
            "Sửa Nhóm $module",
            "Xóa Nhóm $module"
        ];

        $canonicalPermission = [
            "$module.index",
            "$module.create",
            "$module.update",
            "$module.delete",
            "$module.catalouge.index",
            "$module.catalouge.create",
            "$module.catalouge.update",
            "$module.catalouge.delete",
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
        $moduleName = lcfirst($request->input('name'));
        $moduleIcon = $request->input('module_icon');
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

    private function createFile($option, $templatePath, $modulePath)
    {
        $content = file_get_contents($templatePath);
        $newContent = $this->replaceTemplateContent($option, $content);

        if (!File::put($modulePath, $newContent)) return false;

        return $newContent;
    }
}
