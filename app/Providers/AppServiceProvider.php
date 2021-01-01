<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

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
        //
        Blueprint::macro('reference', function () {
            $this->id();
            $this->string('name');
            $this->string('desc')->nullable();
            $this->string('color')->nullable();
            $this->timestamps();
            $this->softDeletes();
        });
    }
}
