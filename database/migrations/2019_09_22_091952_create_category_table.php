<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
	public $table_name = "category";

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
					$table->string('name',255)->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}');

			//Indexes
		
			//foreign
		
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
					$table->string('name',255)->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}');

				} else {
					$table->string('name',255)->comment('{"form":{"label":"Name","sort":999,"key":"name","data_type":"string","type":"text","value":""},"list":{"label":"Name","key":"name","data_type":"string"}}')->change();
				}
			//Indexes
		
			//foreign
		
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
        
				Schema::dropIfExists('category');
    }
}