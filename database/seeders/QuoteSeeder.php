<?php


namespace Database\Seeders;


use App\Models\Character;
use App\Models\Episode;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quote::factory()->times(500)->make()->each(function (Quote $quote) {

            /** @var Episode $episode */
            $episode = Episode::query()->inRandomOrder()->firstOrFail();
            $quote->episode()->associate($episode);

            /** @var Character $character */
            $character = $episode->characters()->inRandomOrder()->firstOrFail();
            $quote->character()->associate($character);

            $quote->save();
        });
    }
}
