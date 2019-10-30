<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
	public $table = "item";

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
					$table->string('name',255)->nullable()->comment('{"form":{"label":"Name","sort":"2","key":"name","data_type":"string","type":"color","value":"","class":"col-5","placeholder":"Enter name here..."},"list":{"label":"Name","key":"name","data_type":"string"}}');
					$table->text('description')->nullable()->comment('{"form":{"label":"Description","sort":"1","key":"description","data_type":"text","type":"textarea","source_view":false,"value":"","required":true},"list":{"label":"Description","key":"description","data_type":"text"}}');
					$table->bigInteger('category_id')->nullable()->unsigned()->comment('{"form":{"label":"Category id","sort":"3","key":"categoryId","data_type":"bigInteger","value":"","type":"select"},"list":{"label":"Category id","key":"categoryId","data_type":"bigInteger"}}');
					$table->decimal('price',10,0)->comment('{"form":{"label":"Price","sort":999,"key":"price","data_type":"decimal","value":"","type":"number","class":"col-3"},"list":{"label":"Price","key":"price","data_type":"decimal"}}');
					$table->boolean('active')->comment('{"form":{"label":"Active","sort":"1","key":"active","data_type":"boolean","type":"boolean","class":"col-3"},"list":{"label":"Active","key":"active","data_type":"boolean"}}');

					$table->timestamps();			$table->unique('name');				
			//foreign
				
				$table->foreign('category_id')->references('id')->on('category');		
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
					$table->string('name',255)->nullable()->comment('{"form":{"label":"Name","sort":"2","key":"name","data_type":"string","type":"color","value":"","class":"col-5","placeholder":"Enter name here..."},"list":{"label":"Name","key":"name","data_type":"string"}}');

				} else {
					$table->string('name',255)->nullable()->comment('{"form":{"label":"Name","sort":"2","key":"name","data_type":"string","type":"color","value":"","class":"col-5","placeholder":"Enter name here..."},"list":{"label":"Name","key":"name","data_type":"string"}}')->change();
				}
				if (!Schema::hasColumn($this->table, 'description')) {
					$table->text('description')->nullable()->comment('{"form":{"label":"Description","sort":"1","key":"description","data_type":"text","type":"textarea","source_view":false,"value":"","required":true},"list":{"label":"Description","key":"description","data_type":"text"}}');

				} else {
					$table->text('description')->nullable()->comment('{"form":{"label":"Description","sort":"1","key":"description","data_type":"text","type":"textarea","source_view":false,"value":"","required":true},"list":{"label":"Description","key":"description","data_type":"text"}}')->change();
				}
				if (!Schema::hasColumn($this->table, 'category_id')) {
					$table->bigInteger('category_id')->nullable()->unsigned()->comment('{"form":{"label":"Category id","sort":"3","key":"categoryId","data_type":"bigInteger","value":"","type":"select"},"list":{"label":"Category id","key":"categoryId","data_type":"bigInteger"}}');

				} else {
					$table->bigInteger('category_id')->nullable()->unsigned()->comment('{"form":{"label":"Category id","sort":"3","key":"categoryId","data_type":"bigInteger","value":"","type":"select"},"list":{"label":"Category id","key":"categoryId","data_type":"bigInteger"}}')->change();
				}
				if (!Schema::hasColumn($this->table, 'price')) {
					$table->decimal('price',10,0)->comment('{"form":{"label":"Price","sort":999,"key":"price","data_type":"decimal","value":"","type":"number","class":"col-3"},"list":{"label":"Price","key":"price","data_type":"decimal"}}');

				} else {
					$table->decimal('price',10,0)->comment('{"form":{"label":"Price","sort":999,"key":"price","data_type":"decimal","value":"","type":"number","class":"col-3"},"list":{"label":"Price","key":"price","data_type":"decimal"}}')->change();
				}
				if (!Schema::hasColumn($this->table, 'active')) {
					$table->boolean('active')->comment('{"form":{"label":"Active","sort":"1","key":"active","data_type":"boolean","type":"boolean","class":"col-3"},"list":{"label":"Active","key":"active","data_type":"boolean"}}');

				} else {
					$table->boolean('active')->comment('{"form":{"label":"Active","sort":"1","key":"active","data_type":"boolean","type":"boolean","class":"col-3"},"list":{"label":"Active","key":"active","data_type":"boolean"}}')->change();
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
				
			if(!array_key_exists($this->table.'_category_id_foreign', $indexesFound)){
				$table->foreign('category_id')->references('id')->on('category')->change();
			}		
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
        
		Schema::dropIfExists('item');
    }
}