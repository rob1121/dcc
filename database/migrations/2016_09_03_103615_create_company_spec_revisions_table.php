<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanySpecRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_spec_revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('revision');
            $table->integer('company_spec_id')->unsigned();
            $table->string('revision_summary');
            $table->date('revision_date');
            $table->string('document')->nullable();
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
        Schema::table('company_spec_revisions', function ($table) {
            $table->dropForeign('company_spec_revisions_company_spec_id_foreign');
        });

        Schema::dropIfExists('company_spec_revisions');
    }
}
