<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSerializer();
    }

    /**
     * @return void
     */
    protected function registerSerializer()
    {
        $this->app->singleton(Serializer::class, function () {
            $serializer = SerializerBuilder::create()
                ->setCacheDir(config('cache.stores.file.path') . DIRECTORY_SEPARATOR . 'jms')
                ->build();

            return $serializer;
        });
    }
}
