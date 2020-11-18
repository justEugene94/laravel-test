<?php


namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CharacterSeeder::class,
            EpisodeSeeder::class,
            QuoteSeeder::class,
        ]);
    }
}
