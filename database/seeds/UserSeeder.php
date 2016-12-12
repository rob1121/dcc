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

        $faker = Faker\Factory::create();
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
        DB::table("users")->truncate();
        DB::table("departments")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");

        $factory = factory(App\User::class);
        factory(App\User::class, 15)->create();
        $user = $factory->create([
            "name" => "admin",
            "employee_id" => 801,
            "password" => bcrypt("admin"),
            "user_type" => "ADMIN",
            "email" => "robinsonlegaspi@astigp.com",
        ]);

        $user->department()->create([
            "user_id" => $user->id,
            "department" => "ADMIN"
        ]);

        foreach(range(1,10) as $count) {


            $user = $factory->create([
                "name" => "user",
                "employee_id" => $faker->randomNumber(5),
                "password" => bcrypt("user"),
                "user_type" => "REVIEWER",
                "email" => $faker->safeEmail(),
            ]);

            foreach($faker->randomElements(['QA','PE','CSD','PL3','RTO','NRTO','HR','PL2','EE','MIS'], rand(1,3)) as $department) {
                factory(App\Department::class)->create([
                    "user_id" => $user->id,
                    "department" => $department
                ]);
            }
        }
    }
}
