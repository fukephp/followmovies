<?php

namespace App\Providers;

use App\Components\MovieComponent;
use Illuminate\Support\ServiceProvider;

class MovieComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('movie', function (){
            return new MovieComponent();
        });
    }

    public function provides(): array
    {
        return [
            'movie',
        ];
    }
}
