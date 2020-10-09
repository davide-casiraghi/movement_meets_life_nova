<?php

namespace Database\Factories;

use App\Models\Insight;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insight::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //if(random_int(0,1))

        $is_posted_on_facebook = 0;
        $published_on_facebook_on = null;
        if (rand(0, 1)){
            $is_posted_on_facebook = 1;
            $timestamp_published_on_facebook_on = rand(1444395410,1602248210);
            $published_on_facebook_on = date("Y-m-d H:i:s",$timestamp_published_on_facebook_on);
        }

        $is_posted_on_twitter = 0;
        $published_on_facebook_on = null;
        if (rand(0, 1)){
            $is_posted_on_twitter = 1;
            $timestamp_published_on_twitter_on = rand(1444395410,1602248210);
            $published_on_twitter_on = date("Y-m-d H:i:s",$timestamp_published_on_twitter_on);
        }
        $published = 0;
        if (rand(0, 1)){
            $published = 1;
        }

        return [
            'title' => $this->faker->sentence($nbWords = 7, $variableNbWords = true),
            'description' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'is_published' => $published,
            'is_posted_on_facebook' => $is_posted_on_facebook,
            'published_on_facebook_on' => $published_on_facebook_on,
            'is_posted_on_twitter' => $is_posted_on_twitter,
            'published_on_twitter_on' => $published_on_twitter_on,
        ];
    }
}
