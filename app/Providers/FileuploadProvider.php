<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class FileuploadProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      App::bind('Fileupload',function() {
         return new \App\Helpers\Fileupload;
      });
    }
}
