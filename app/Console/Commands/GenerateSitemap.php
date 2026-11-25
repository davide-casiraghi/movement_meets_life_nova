<?php

namespace App\Console\Commands;

use App\Services\EventService;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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

    private EventService $eventService;

    private PostService $postService;

    private PostCategoryService $postCategoryService;

  /**
   * Create a new command instance.
   *
   * @param  EventService  $eventService
   * @param  PostService  $postService
   * @param  PostCategoryService  $postCategoryService
   */
    public function __construct(
        EventService $eventService,
        PostService $postService,
        PostCategoryService $postCategoryService
    ) {
        parent::__construct();
        $this->eventService = $eventService;
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        $pages = [
            '/learn-more-ilan-lev-method',
            '/contact-improvisation',
            '/contact',
        ];

        foreach ($pages as $page) {
            $this->addLocalizedUrl($sitemap, $page);
        }

        // Pages with a translated URL (see resources/lang/*/routes.php)
        $this->addTranslatedRouteUrl($sitemap, 'routes.book-a-treatment');
        $this->addTranslatedRouteUrl($sitemap, 'routes.blog');
        $this->addTranslatedRouteUrl($sitemap, 'routes.physiotherapy');
        $this->addTranslatedRouteUrl($sitemap, 'routes.about-me');
        $this->addTranslatedRouteUrl($sitemap, 'routes.treatments-ilan-lev-method');

        // BLOG POSTS (published posts of the blog category)
        $blogCategoryId = $this->postCategoryService->getIdByCategoryName('blog');
        $posts = $this->postService->getPosts(null, [
            'status' => 'published',
            'categoryId' => $blogCategoryId,
        ]);
        foreach ($posts as $post) {
            // Each language has its own translated slug
            $this->addAlternateUrls($sitemap, $this->postService->getLocalizedUrls($post));
        }

        // EVENTS
        $searchParameters = [];
        $searchParameters['startDate'] = Carbon::today()->format('d/m/Y');
        $searchParameters['is_published'] = true;
        $events = $this->eventService->getEvents(null, $searchParameters);
        foreach ($events as $event) {
            $this->addLocalizedUrl($sitemap, "/events/{$event->slug}");
        }

        // Write Sitemap to file
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }

    /**
     * Add a page once per supported language, each entry listing all the
     * language versions as hreflang alternates (itself included).
     *
     * @param  Sitemap  $sitemap
     * @param  string  $path
     */
    private function addLocalizedUrl(Sitemap $sitemap, string $path): void
    {
        $localizedUrls = [];
        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
            $localizedUrls[$locale] = LaravelLocalization::getLocalizedURL($locale, url($path), [], true);
        }

        $this->addAlternateUrls($sitemap, $localizedUrls);
    }

    /**
     * Add one entry per language version of a page, each listing all the
     * language versions as hreflang alternates (itself included).
     *
     * @param  Sitemap  $sitemap
     * @param  array<string, string>  $localizedUrls  URLs keyed by locale
     */
    private function addAlternateUrls(Sitemap $sitemap, array $localizedUrls): void
    {
        foreach ($localizedUrls as $url) {
            $tag = Url::create($url);
            foreach ($localizedUrls as $alternateLocale => $alternateUrl) {
                $tag->addAlternate($alternateUrl, $alternateLocale);
            }
            $sitemap->add($tag);
        }
    }

    /**
     * Add a page whose URL is translated per language (see resources/lang/<locale>/routes.php).
     *
     * @param  Sitemap  $sitemap
     * @param  string  $translationKey
     */
    private function addTranslatedRouteUrl(Sitemap $sitemap, string $translationKey): void
    {
        $localizedUrls = [];
        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
            $url = LaravelLocalization::getURLFromRouteNameTranslated($locale, $translationKey, [], true);
            if ($url !== false) {
                $localizedUrls[$locale] = $url;
            }
        }

        $this->addAlternateUrls($sitemap, $localizedUrls);
    }
}
