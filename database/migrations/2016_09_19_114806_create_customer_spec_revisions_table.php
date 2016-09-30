<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSpecRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_spec_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('revision');
            $table->integer('customer_spec_id')->unsigned();
            $table->date('revision_date');
            $table->string('document')->nullable();
            $table->string('reviewer');
            $table->boolean('is_reviewed')->default(false);
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
        Schema::table('customer_spec_revisions', function ($table) {
            $table->dropForeign('customer_spec_revisions_customer_spec_id_foreign');
        });

        Schema::dropIfExists('customer_spec_revisions');
    }
}
