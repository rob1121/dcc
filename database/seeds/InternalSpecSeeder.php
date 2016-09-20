<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InternalSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $specs_category = [
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

        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        DB::table('company_specs')->truncate();
        DB::table('company_spec_revisions')->truncate();
        DB::table('company_spec_categories')->truncate();
        DB::table('users')->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");

        for ($i = 0; $i < 25; $i++) {
            $rand_id = rand(1, 20);
            $rev = sprintf("%03d", $rand_id);

            factory('App\User', 10)->create();

            $category_no = $faker->randomElement($specs_category);

            $id = factory('App\CompanySpec')->create([
                'spec_no' => "{$category_no}-{$rev}",
                "name" => $faker->sentence(rand(3,8))
            ])->id;

            factory('App\CompanySpecRevision', $rand_id)->create([
                'company_spec_id' => $id,
            ]);

            factory('App\CompanySpecCategory')->create([
                'company_spec_id' => $id,
                'category_no' => $category_no,
                'category_name' => "category name for {$category_no}"
            ]);
        }

        $this->command->info("Users table seeded");

        $this->command->info("Internal spec table seeded");
    }
}
