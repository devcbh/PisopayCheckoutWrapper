<?php

namespace Devcbh\CheckoutWrapper;

use Illuminate\Support\ServiceProvider;

class CheckoutWrapperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/checkout-wrapper.php', 'checkout-wrapper'
        );

        // Register the Checkout class in the service container
        $this->app->singleton(Checkout::class, function ($app) {
            return new Checkout();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/checkout-wrapper.php' => config_path('checkout-wrapper.php'),
        ], 'config');

        // Register facade
        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Checkout', \Devcbh\CheckoutWrapper\Facades\Checkout::class);
        });
    }
}
