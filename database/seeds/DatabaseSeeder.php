<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
el        $this->call(UserSeeder::class);
        $this->call(InternalSpecSeeder::class);
        $this->call(ExternalSpecSeeder::class);
        $this->call(IsoSeeder::class);
    }
}
