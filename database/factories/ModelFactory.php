<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\CompanySpec::class, function (Faker\Generator $faker) {
    return [
        'spec_no' =>  $faker->word ,
        'name' =>  $faker->name ,
    ];
});

$factory->define(App\CompanySpecCategory::class, function (Faker\Generator $faker) {
    return [
        'company_spec_id' =>  function () {
        $id = factory(App\CompanySpec::class)->create()->id;

            factory(App\CompanySpecRevision::class)->create(['company_spec_id' => $id]);
             return $id;
        } ,
        'category_no' =>  $faker->word ,
        'category_name' =>  $faker->word ,
    ];
});

$factory->define(App\CompanySpecRevision::class, function (Faker\Generator $faker) {
    return [
        'revision' =>  $faker->word ,
        'company_spec_id' =>  function () {
             return factory(App\CompanySpec::class)->create()->id;
        } ,
        'revision_summary' =>  $faker->word ,
        'revision_date' =>  $faker->date() ,
        'document' =>  $faker->word ,
    ];
});

