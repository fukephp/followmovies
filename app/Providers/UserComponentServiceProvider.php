<?php

namespace App\Providers;

use App\Components\UserComponent;
use Illuminate\Support\ServiceProvider;

class UserComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('user', function (){
            return new UserComponent();
        });
    }

    public function provides(): array
    {
        return [
            'user',
        ];
    }
}
