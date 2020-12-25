<?php

namespace App\Providers;

use App\Http\View\Composer\QuoteComposer;
use App\Models\Post;
use App\Models\Quote;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //View::share('posts', Post::orderBy('title')->get());

      /*  View::composer('partials.pages.home.blog.block', function($view){
            $view->with('posts', Post::currentStatus('Published')->orderBy('created_at', 'desc')->take(3)->get());
        });

        View::composer('posts.index', function($view){
            $view->with('posts', Post::currentStatus('Published')->orderBy('created_at', 'desc')->paginate(6));
        });*/

        View::composer(['partials.quote_of_the_day'], QuoteComposer::class);



    }
}
