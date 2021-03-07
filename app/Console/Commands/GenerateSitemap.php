<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private PostService $postService;

    public function __construct(
        PostService $postService
    ) {
        parent::__construct();
        $this->postService = $postService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
        ->add(Url::create('/blog'))
        ->add(Url::create('/next_events'))
        ->add(Url::create('/treatments-ilan-lev-method'))
          ->add(Url::create('/contact-improvisation'))
          ->add(Url::create('/getATreatment'))
          ->add(Url::create('/aboutMe'))
          ->add(Url::create('/contact'));

        // POSTS
        $posts = $this->postService->getPosts(null, ['status' => 'published']);
        foreach ($posts as $post) {
            $sitemap->add(Url::create("/posts/{$post->slug}"));
        }
        


        // Write Sitemap to file
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
