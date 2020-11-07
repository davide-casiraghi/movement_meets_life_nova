<?php

namespace Database\Factories;

use App\Models\Insight;
use App\Services\GlobalServices;
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
        $is_posted_on_facebook = GlobalServices::getRandomWeightedElement(['1'=>85, '0'=>15 ]);
        $published_on_facebook_on = null;
        if ($is_posted_on_facebook){
            $timestamp_published_on_facebook_on = rand(1444395410,1602248210);
            $published_on_facebook_on = date("Y-m-d H:i:s",$timestamp_published_on_facebook_on);
        }

        // Generate published on twitter date
        $is_posted_on_twitter = GlobalServices::getRandomWeightedElement(['1'=>85, '0'=>15 ]);
        $published_on_twitter_on = null;
        if ($is_posted_on_twitter){
            $timestamp_published_on_twitter_on = rand(1444395410,1602248210);
            $published_on_twitter_on = date("Y-m-d H:i:s",$timestamp_published_on_twitter_on);
        }

        return [
            'title' => [
                'en' => $this->faker->sentence($nbWords = 7, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 7, $variableNbWords = true),
            ],
            'description' => [
                'en' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
                'it' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            ],
            'introimage_alt' => [
                'en' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            ],
            //'is_published' => GlobalServices::getRandomWeightedElement(['1'=>85, '0'=>15 ]),
            'is_posted_on_facebook' => $is_posted_on_facebook,
            'published_on_facebook_on' => $published_on_facebook_on,
            'is_posted_on_twitter' => $is_posted_on_twitter,
            'published_on_twitter_on' => $published_on_twitter_on,
            'introimage' => 'placeholders/placeholder-768x768.png',
        ];
    }
}
