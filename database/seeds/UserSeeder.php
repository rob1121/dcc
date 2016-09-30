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
        \DB::table("users")->truncate();

        $factory = factory(App\User::class);

        $factory->create([
            "name" => "admin",
            "employee_id" => 801,
            "password" => bcrypt("admin"),
            "department" => "QA",
            "is_admin" => 1
        ]);

        $factory->create([
            "name" => "user",
            "employee_id" => 802,
            "password" => bcrypt("user"),
            "department" => "QA",
            "is_admin" => 0
        ]);
    }
}
