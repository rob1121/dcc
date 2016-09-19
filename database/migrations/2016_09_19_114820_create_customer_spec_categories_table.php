<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSpecCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_spec_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_spec_id')->unsigned()->unique();
            $table->string('customer_name');
            $table->foreign('customer_spec_id')->references('id')->on('customer_specs')->onDelete('cascade');
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
        Schema::table('customer_spec_categories', function ($table) {
            $table->dropForeign('customer_spec_categories_customer_spec_id_foreign');
        });
        Schema::dropIfExists('customer_spec_categories');
    }
}
