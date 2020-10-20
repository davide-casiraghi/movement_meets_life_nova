<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Spatie\NovaTranslatable\Translatable::defaultLocales(['en', 'it']);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //View::share('posts', Post::orderBy('title')->get());

        View::composer('partials.home.blog', function($view){
            $view->with('posts', Post::where('is_published', 1)->orderBy('created_at', 'desc')->take(3)->get());
        });

        View::composer('posts.index', function($view){
            $view->with('posts', Post::where('is_published', 1)->orderBy('created_at', 'desc')->paginate(6));
        });

    }
}
