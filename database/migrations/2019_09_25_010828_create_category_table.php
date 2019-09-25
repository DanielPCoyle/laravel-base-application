<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
	public $table = "category";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable($this->table)) {
			Schema::create($this->table, function (Blueprint $table) {
					$table->bigIncrements('id')->comment('{"form":{"label":"Id","sort":999,"key":"id","data_type":"bigIncrements","value":""},"list":{"label":"Id","key":"id","data_type":"bigIncrements"}}');
					$table->string('name',255)->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}');
					$table->text('description')->nullable()->comment('{"form":{"label":"Description","sort":999,"key":"description","data_type":"text","type":"textarea","source_view":false,"value":""},"list":{"label":"Description","key":"description","data_type":"text"}}');

					$table->timestamps();			$table->unique('name');	
			//foreign
			
			});
		}
		else  if (Schema::hasTable($this->table)) {
			Schema::table($this->table, function (Blueprint $table) {

				if (!Schema::hasColumn($this->table, 'id')) {
					$table->bigIncrements('id')->comment('{"form":{"label":"Id","sort":999,"key":"id","data_type":"bigIncrements","value":""},"list":{"label":"Id","key":"id","data_type":"bigIncrements"}}');

				} else {
					$table->bigIncrements('id')->comment('{"form":{"label":"Id","sort":999,"key":"id","data_type":"bigIncrements","value":""},"list":{"label":"Id","key":"id","data_type":"bigIncrements"}}')->change();
				}
				if (!Schema::hasColumn($this->table, 'name')) {
					$table->string('name',255)->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}');

				} else {
					$table->string('name',255)->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}')->change();
				}
				if (!Schema::hasColumn($this->table, 'description')) {
					$table->text('description')->nullable()->comment('{"form":{"label":"Description","sort":999,"key":"description","data_type":"text","type":"textarea","source_view":false,"value":""},"list":{"label":"Description","key":"description","data_type":"text"}}');

				} else {
					$table->text('description')->nullable()->comment('{"form":{"label":"Description","sort":999,"key":"description","data_type":"text","type":"textarea","source_view":false,"value":""},"list":{"label":"Description","key":"description","data_type":"text"}}')->change();
				}

			if (!Schema::hasColumn($this->table, 'created_at')) {
				$table->timestamps();
			}

			$sm = Schema::getConnection()->getDoctrineSchemaManager();
			$indexesFound = $sm->listTableIndexes($this->table);
			//Indexes
		
			if(!array_key_exists($this->table.'_name_unique', $indexesFound)){	$table->unique('name')->change();
			}	
			//foreign
			
			//Dropped Columns

			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
		Schema::dropIfExists('category');
    }
}