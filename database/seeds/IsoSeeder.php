<?php

use Illuminate\Database\Seeder;

class IsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('isos')->truncate();

        factory(App\Iso::class, 5)->create();
        $this->command->info("Iso spec table seeded");
    }
}
