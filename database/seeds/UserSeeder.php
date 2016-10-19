<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        \DB::table("users")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");

        $factory = factory(App\User::class);
        factory(App\User::class, 15)->create();
        $factory->create([
            "name" => "admin",
            "employee_id" => 801,
            "password" => bcrypt("admin"),
            "department" => "ADMIN",
            "user_type" => "ADMIN",
            "email" => "robinsonlegaspi@astigp.com",
        ]);

        $factory->create([
            "name" => "user",
            "employee_id" => 802,
            "password" => bcrypt("user"),
            "department" => "QA",
            "user_type" => "REVIEWER",
            "email" => "robinson.legaspi@yahoo.com"
        ]);
    }
}
