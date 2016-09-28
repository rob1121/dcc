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
        factory(App\User::class)->create([
            "name" => "Rob",
            "employee_id" => 801,
            "is_admin" => 1,
            "password" => bcrypt("admin"),
            "email" => "robinsolegaspi@astigp.com"
        ]);
        $this->call(InternalSpecSeeder::class);
        $this->call(ExternalSpecSeeder::class);
    }
}
