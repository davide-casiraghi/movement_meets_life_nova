<?php

namespace Database\Factories;

use App\Helpers\Helper;
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
        // Generate posted on facebook date
        $timestamp_published_on_facebook_on = rand(1444395410, 1602248210);
        $published_on_facebook_on = date("Y-m-d H:i:s", $timestamp_published_on_facebook_on);

        // Generate published on twitter date
        $timestamp_published_on_twitter_on = rand(1444395410, 1602248210);
        $published_on_twitter_on = date("Y-m-d H:i:s", $timestamp_published_on_twitter_on);

        // Generate published on instagram date
        $timestamp_published_on_instagram_on = rand(1444395410, 1602248210);
        $published_on_instagram_on = date("Y-m-d H:i:s", $timestamp_published_on_instagram_on);

        return [
            'title' => [
                'en' => $this->faker->sentence($nbWords = 7, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 7, $variableNbWords = true),
            ],
            'body' => [
                'en' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
                'it' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            ],
            'introimage' => 'placeholders/placeholder-768x768.png',
            'introimage_alt' => [
                'en' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            ],

            'facebook_body' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'facebook_url' => $this->faker->url(),
            'published_on_facebook_on' => $published_on_facebook_on,

            'twitter_body' => $this->faker->text(280),
            'twitter_url' => $this->faker->url(),
            'published_on_twitter_on' => $published_on_twitter_on,

            'instagram_body' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'instagram_url' => $this->faker->url(),
            'published_on_instagram_on' => $published_on_instagram_on,
        ];
    }
}
