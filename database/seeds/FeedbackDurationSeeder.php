<?php

use Illuminate\Database\Seeder;
use App\FeedbackDuration;

class FeedbackDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $durations = ['1 month' => 2649600, '3 months' => 7948800, '6 months' => 15897600, '12 months' => 31795200];

        foreach ($durations as $key => $duration) {

            $new = new FeedbackDuration();

            $new->name = $key;
            $new->value = $duration;

            $new->save();
        }
    }
}
