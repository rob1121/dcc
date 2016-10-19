<?php

$spec_category = [
    "TFP01",
    'TFP02',
    'TFP03',
    'TFP04',
    'TFP05',
    'TFP06',
    'TFP07',
    'TFP08',
    'TFP09',
    'TFP10',
    'TFP11',
    'TFP12'
];

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'department' => $faker->randomElement(["QA","PE"]),
        'employee_id' => $faker->numberBetween(),
        'user_type' => $faker->randomElement(["ADMIN","REVIEWER","EMAIL RECEIVER ONLY"]),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Originator::class, function (Faker\Generator $faker) {
    return [
        'company_spec_id' => function() {
            return factory(\App\CompanySpec::class)->create()->id;
        },
        'department' => $faker->randomElement(["QA","PE"])
    ];
});

$factory->define(App\CompanySpec::class, function (Faker\Generator $faker) {
    return [
        'spec_no' =>  $faker->word() ,
        'name' =>  $faker->sentence() ,
    ];
});

$factory->define(App\CompanySpecCategory::class, function (Faker\Generator $faker) use($spec_category) {
    return [
        'company_spec_id' => function () {
            return factory(App\CompanySpec::class)->create()->id;
        } ,
        'category_no' =>  $faker->randomElement($spec_category) ,
        'category_name' =>  $faker->sentence(rand(3,5)) ,
    ];
});

$factory->define(App\CompanySpecRevision::class, function (Faker\Generator $faker) {
    return [
        'revision' =>  $faker->randomElement(['AA','BB','**','*A','*C','ZZ','AB']) ,
        'company_spec_id' =>  function () {
            return factory(App\CompanySpec::class)->create()->id;
        } ,
        'revision_summary' =>  $faker->sentence() ,
        'revision_date' =>  $faker->date() ,
        'document' =>  $faker->word() ,
    ];
});








$factory->define(App\CustomerSpec::class, function (Faker\Generator $faker) {
    return [
        'spec_no' =>  $faker->word() ,
        'name' =>  $faker->sentence() ,
        'reviewer' =>  $faker->randomElement(["QA","PE"]) ,
    ];
});

$factory->define(App\CustomerSpecCategory::class, function (Faker\Generator $faker) use($spec_category) {
    return [
        'customer_spec_id' =>  function() {
        return factory(App\CustomerSpec::class)->create()->id;
        },
        'customer_name' =>  $faker->company ,
    ];
});

$factory->define(App\CustomerSpecRevision::class, function (Faker\Generator $faker) {
    return [
        'revision' =>  $faker->randomElement(['AA','BB','**','*A','*C','ZZ','AB']) ,
        'revision_date' =>  $faker->date() ,
        'customer_spec_id' =>  function() {
            return factory(App\CustomerSpec::class)->create()->id;
        },
        'is_reviewed' => $faker->randomElement([true,false]),
        'document' =>  $faker->word() ,
    ];
});


$factory->define(App\Iso::class, function (Faker\Generator $faker) {
    return [
        'spec_no' =>  $faker->word ,
        'name' =>  $faker->name ,
        'document' =>  $faker->word ,
        'revision' => $faker->word,
        'revision_date' => $faker->date()
    ];
});

