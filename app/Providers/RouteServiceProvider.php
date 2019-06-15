<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->registerRouteModelBindings();
    }

    public function map()
    {
        $this->mapFrontRoutes();
    }

    protected function mapFrontRoutes()
    {
        Route::middleware(['web', 'cacheResponse'])
            ->group(base_path('routes/web.php'));
    }

    public function registerRouteModelBindings()
    {
        Route::bind('postSlug', function ($slug) {
            $post = Post::findByIdSlug($slug);

            if (! $post) {
                $post = Post::where('slug', $slug)->first();
            }

            if (! $post) {
                abort(404);
            }

            if (auth()->check()) {
                return $post;
            }

            if (!$post->published) {
                abort(404);
            }

            return $post;
        });

        Route::bind('tag', function ($slug) {
            $tag = Tag::findFromString($slug);

            if (! $tag) {
                abort(404);
            }

            return $tag;
        });
    }
}
