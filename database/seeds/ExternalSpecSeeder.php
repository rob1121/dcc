<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExternalSpecSeeder extends Seeder
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
        DB::table('customer_specs')->truncate();
        DB::table('customer_spec_revisions')->truncate();
        DB::table('customer_spec_categories')->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");

        for ($i = 0; $i < 25; $i++) {
            $rand_id = rand(1, 50);
            $rev = sprintf("%03d", $rand_id);

            $category_no = $faker->randomElement($specs_category);

            $id = factory('App\CustomerSpec')->create([
                'spec_no' => "{$category_no}-{$rev}",
                "name" => $faker->sentence(rand(3,8))
            ])->id;

            factory('App\CustomerSpecRevision', $rand_id)->create([
                'customer_spec_id' => $id,
            ]);

            factory('App\CustomerSpecCategory')->create([
                'customer_spec_id' => $id,
                'customer_name' => $faker->randomElement(["ADGT","CML","MICROCHIP","AMS"])
            ]);
        }
        $this->command->info("External spec table seeded");
    }
}
