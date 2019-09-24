<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
	public $table_name = "items";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable($this->table_name)) {
			Schema::create($this->table_name, function (Blueprint $table) {
					$table->bigIncrements('id')->comment('{"form":{"label":"Id","sort":999,"key":"id","data_type":"bigIncrements","value":""},"list":{"label":"Id","key":"id","data_type":"bigIncrements"}}');
					$table->string('name',255)->nullable()->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}');
					$table->text('price')->comment('{"form":{"label":"Price","sort":999,"key":"price","data_type":"text","type":"textarea","source_view":false,"value":""},"list":{"label":"Price","key":"price","data_type":"text"}}');
					$table->integer('description')->nullable()->comment('{"form":{"label":"Description","sort":999,"key":"description","data_type":"integer","value":"","type":"number"},"list":{"label":"Description","key":"description","data_type":"integer"}}');
					$table->bigInteger('category_id')->unsigned()->comment('{"form":{"label":"Category id","sort":999,"key":"categoryId","data_type":"bigInteger","value":""},"list":{"label":"Category id","key":"categoryId","data_type":"bigInteger"}}');

			//Indexes
					
			//foreign
							$table->foreign('category_id')->references('id')->on('category');

			});
		}
		else  if (Schema::hasTable($this->table_name)) {
			Schema::table($this->table_name, function (Blueprint $table) {

				if(!Schema::hasColumn($this->table_name, 'id')){
					$table->bigIncrements('id')->comment('{"form":{"label":"Id","sort":999,"key":"id","data_type":"bigIncrements","value":""},"list":{"label":"Id","key":"id","data_type":"bigIncrements"}}');

				} else {
					$table->bigIncrements('id')->comment('{"form":{"label":"Id","sort":999,"key":"id","data_type":"bigIncrements","value":""},"list":{"label":"Id","key":"id","data_type":"bigIncrements"}}')->change();
				}
				if(!Schema::hasColumn($this->table_name, 'name')){
					$table->string('name',255)->nullable()->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}');

				} else {
					$table->string('name',255)->nullable()->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}')->change();
				}
				if(!Schema::hasColumn($this->table_name, 'price')){
					$table->text('price')->comment('{"form":{"label":"Price","sort":999,"key":"price","data_type":"text","type":"textarea","source_view":false,"value":""},"list":{"label":"Price","key":"price","data_type":"text"}}');

				} else {
					$table->text('price')->comment('{"form":{"label":"Price","sort":999,"key":"price","data_type":"text","type":"textarea","source_view":false,"value":""},"list":{"label":"Price","key":"price","data_type":"text"}}')->change();
				}
				if(!Schema::hasColumn($this->table_name, 'description')){
					$table->integer('description')->nullable()->comment('{"form":{"label":"Description","sort":999,"key":"description","data_type":"integer","value":"","type":"number"},"list":{"label":"Description","key":"description","data_type":"integer"}}');

				} else {
					$table->integer('description')->nullable()->comment('{"form":{"label":"Description","sort":999,"key":"description","data_type":"integer","value":"","type":"number"},"list":{"label":"Description","key":"description","data_type":"integer"}}')->change();
				}
				if(!Schema::hasColumn($this->table_name, 'category_id')){
					$table->bigInteger('category_id')->unsigned()->comment('{"form":{"label":"Category id","sort":999,"key":"categoryId","data_type":"bigInteger","value":""},"list":{"label":"Category id","key":"categoryId","data_type":"bigInteger"}}');

				} else {
					$table->bigInteger('category_id')->unsigned()->comment('{"form":{"label":"Category id","sort":999,"key":"categoryId","data_type":"bigInteger","value":""},"list":{"label":"Category id","key":"categoryId","data_type":"bigInteger"}}')->change();
				}
			//Indexes
					
			//foreign
							$table->foreign('category_id')->references('id')->on('category')->change();

			//Dropped Columns
		
	if(Schema::hasColumn($this->table_name, 'Items')){
		$table->dropColumn('Items');
	}
	if(Schema::hasColumn($this->table_name, 'Category')){
		$table->dropColumn('Category');
	}

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
        
				Schema::dropIfExists('items');
    }
}