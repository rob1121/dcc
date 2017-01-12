<?php

use Illuminate\Database\Seeder;

class ESDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('esd')->truncate();

        factory(App\Esd::class, 5)->create();
        $this->command->info("ESD spec table seeded");
    }
}
