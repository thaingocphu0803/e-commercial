<?php

namespace App\Services;

use App\Repositories\GenerateRepository;
use App\Services\Interfaces\GenerateServiceInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Class GenerateService
 * @package App\Services
 */
class GenerateService implements GenerateServiceInterface
{
    protected $generateRepository;

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

            // $this->makeController();
            // $this->makeModel();
            // $this->makeRepository();
            // $this->makeService();
            // $this->makeProvider();
            // $this->makeRequest();
            // $this->makeView();
            // $this->makeRoute();
            // $this->makeRule();
            // $this->makeLang();
            $payload = $request->except(['_token']);

            $this->generateRepository->create($payload);

            DB::commit();
            $this->makeDatabase($request);

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

    private function makeDatabase($request){
        $payload = $request->only('name', 'schema', 'module_type');
        $migrationTableName = $this->convertToTableName($payload['name']);
        $migrationFileName = date('Y_m_d_His').'_create_'.$migrationTableName.'s_table.php';
        $migrationPath = database_path("migrations\\$migrationFileName");

        $migrationContent = $this->mainSchema($payload['schema'], $migrationTableName);

        $filePut = File::put($migrationPath, $migrationContent);
        if(!$filePut) return false;

        if($payload['module_type']!= 3){
            $migrationPivotContent = $this->pivotSchema($migrationTableName);
            $migrationPivotFileName = date('Y_m_d_His').'_create_'.$migrationTableName.'_language_table.php';

            $migrationPivotPath = database_path("migrations\\$migrationPivotFileName");

            $filePivotPut = File::put($migrationPivotPath, $migrationPivotContent);
            if(!$filePivotPut) return false;

            // $runMigate = Artisan::call('migrate');
            // if($runMigate != 0) return false;
        }

        return true;
    }

    private function pivotSchema($migrationTableName){
        return <<<PIVOT
<?php

use App\Models\Language;
use App\Models\PostCatalouge;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('{$migrationTableName}_language', function (Blueprint \$table) {
            \$table->foreignId('{$migrationTableName}_id')->constrained('{$migrationTableName}s')->cascadeOnDelete();
            \$table->foreignIdFor(Language::class, 'language_id')->constrained()->cascadeOnDelete();
            \$table->string('name');
            \$table->text('description')->nullable();
            \$table->longText('content')->nullable();
            \$table->string('meta_title')->nullable();
            \$table->string('meta_keyword')->nullable();
            \$table->text('meta_description')->nullable();
            \$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$migrationTableName}_language');
    }
};

PIVOT;
    }

    private function mainSchema($schema, $migrationTableName){
        return <<<MAIN
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        {$schema}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$migrationTableName}s');
    }
};
MAIN;
    }

    private function convertToTableName($name){
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        return $temp;
    }
}
