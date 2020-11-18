<?php


namespace Database\Seeders;


use App\Models\Character;
use App\Models\Episode;
use Illuminate\Database\Seeder;

class EpisodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Episode::factory()->times(30)->create()->each(function (Episode $episode) {
            $this->syncCharacters($episode);
        });
    }

    /**
     * @param Episode $episode
     */
    protected function syncCharacters(Episode $episode): void
    {
        $characters = Character::query()->limit(rand(5, 15))->inRandomOrder()->get()->pluck('id')->toArray();

        $episode->characters()->sync($characters);
    }
}
