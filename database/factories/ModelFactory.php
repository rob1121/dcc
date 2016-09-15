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
        'employee_id' => $faker->numberBetween(),
        'is_admin' => $faker->randomElement([1,0]),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\CompanySpec::class, function (Faker\Generator $faker) {
    return [
        'spec_no' =>  $faker->word() ,
        'name' =>  $faker->sentence() ,
    ];
});

$factory->define(App\CompanySpecCategory::class, function (Faker\Generator $faker) {
    return [
        'company_spec_id' =>  function () {
             return factory(App\CompanySpec::class)->create()->id;
        } ,
        'category_no' =>  $faker->randomElement(["TFP01",'TFP02','TFP03','TFP04','TFP05','TFP06','TFP07','TFP08','TFP09','TFP10','TFP11','TFP12']) ,
        'category_name' =>  $faker->sentence(rand(3,5)) ,
    ];
});

$factory->define(App\CompanySpecRevision::class, function (Faker\Generator $faker) {
    return [
        'revision' =>  $faker->text(5) ,
        'company_spec_id' =>  function () {
             return factory(App\CompanySpec::class)->create()->id;
        } ,
        'revision_summary' =>  $faker->sentence() ,
        'revision_date' =>  $faker->date() ,
        'document' =>  $faker->word() ,
    ];
});

