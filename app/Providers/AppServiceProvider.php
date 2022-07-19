<?php

namespace App\Providers;

use App\Models\Community;
use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Observers\PostVoteObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::share('newestPosts', Post::with('community')->latest()->take(5)->get());
        View::share('newestCommunities', Community::withCount('posts')->latest()->take(5)->get());

        PostVote::observe(PostVoteObserver::class);


        // Option 2
        // View::composer('app', function($view)
        // {
        //     $view->with('newestPosts', Post::with('community')->latest()->take(5)->get());
        //     $view->with('newestCommunities', Community::withCount('posts')->latest()->take(5)->get());

        // });



    }
}
