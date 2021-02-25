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
        // Facebook data
        $publishedOnFacebookOn = $facebookUrl = $facebookBody = null;
        if ($this->faker->boolean(50)) {
            $timestamp_published_on_facebook_on = rand(1444395410, 1602248210);
            $publishedOnFacebookOn = date("Y-m-d H:i:s", $timestamp_published_on_facebook_on);
            $facebookUrl = $this->faker->url();
            $facebookBody = $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true);
        }

        // Twitter data
        $publishedOnTwitterOn = $twitterUrl = $twitterBody = null;
        if ($this->faker->boolean(50)) {
            $timestamp_published_on_twitter_on = rand(1444395410, 1602248210);
            $publishedOnTwitterOn = date("Y-m-d H:i:s", $timestamp_published_on_twitter_on);
            $twitterUrl = $this->faker->url();
            $twitterBody = $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true);
        }

        // Instagram data
        $publishedOnInstagramOn = $instagramUrl = $instagramBody = null;
        if ($this->faker->boolean(50)) {
            $timestamp_published_on_instagram_on = rand(1444395410, 1602248210);
            $publishedOnInstagramOn = date("Y-m-d H:i:s", $timestamp_published_on_instagram_on);
            $instagramUrl = $this->faker->url();
            $instagramBody = $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true);
        }

        return [
            'title' => $this->faker->sentence($nbWords = 7, $variableNbWords = true),
            'body' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'introimage' => 'placeholders/placeholder-768x768.png',
            'introimage_alt' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),

            'is_published' => $this->faker->boolean(50),

            'facebook_body' => $facebookBody,
            'facebook_url' => $facebookUrl,
            'published_on_facebook_on' => $publishedOnFacebookOn,

            'twitter_body' => $twitterBody,
            'twitter_url' => $twitterUrl,
            'published_on_twitter_on' => $publishedOnTwitterOn,

            'instagram_body' => $instagramBody,
            'instagram_url' => $instagramUrl,
            'published_on_instagram_on' => $publishedOnInstagramOn,
        ];
    }
}
