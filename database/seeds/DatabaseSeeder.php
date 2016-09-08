<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        DB::table('company_specs')->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");

        factory('App\CompanySpecCategory', 100)->create();

//        $this->call(UsersTableSeeder::class);

    }
}
