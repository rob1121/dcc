<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySpecCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_spec_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_spec_id')->unsigned()->unique();
            $table->string('category_no');
            $table->string('category_name');
            $table->foreign('company_spec_id')->references('id')->on('company_specs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_spec_categories', function ($table) {
            $table->dropForeign('company_spec_categories_company_spec_id_foreign');
        });
        Schema::dropIfExists('company_spec_categories');
    }
}
