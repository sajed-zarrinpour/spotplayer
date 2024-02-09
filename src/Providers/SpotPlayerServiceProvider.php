<?php

namespace SajedZarinpour\Spotplayer\Providers;

use Illuminate\Support\ServiceProvider;

use SajedZarinpour\Spotplayer\SpotPlayer;

class SpotPlayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /** registering the controller */ 
        $this->app->make('SajedZarinpour\Spotplayer\Controllers\SpotPlayerController');

        /** binding the spotplayer */
        $this->app->bind('spot-player', function(){
            return new SpotPlayer();
        });

        /** disable cookie encryption for this specific cookie */
        $this->app->resolving(EncryptCookies::class, function ($object) {
            $object->disableFor('X');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /** routes of the package */
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        /** views of the package */
        $this-> loadViewsFrom(__DIR__.'/../views', 'spotplayer');
        
        /** package publishable files */
        $this->publishes([
            __DIR__.'/../config/spotplayer.php' => config_path('spotplayer.php'),
        ]);

    
    }
}
