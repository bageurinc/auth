<?php

namespace Bageur\Auth;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Bageur\Auth\Controllers\PasswordResetController');
        $this->app->make('Bageur\Auth\Controllers\UserController');
        $this->app->make('Bageur\Auth\Controllers\AuthController');
        $this->app->make('Bageur\Auth\Controllers\MenuController');
        $this->app->make('Bageur\Auth\Controllers\LevelController');
        $this->app->make('Bageur\Auth\Controllers\MenuActionController');
        $this->app->make('Bageur\Auth\Controllers\PerkakasController');
       
       $this->app->bind('bageur',function(){
            return new Facades\Bageur();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/view', 'bageur');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migration');
        $this->publishes([
                             __DIR__.'/config/auth.php'                 => config_path('bageur/auth.php'),
                             __DIR__.'/assets'                          => public_path('vendor/bageur'),
                             __DIR__.'/middleware/BageurMiddleware.php' => app_path('http/Middleware/BageurMiddleware.php'),
                         ], 'bageur-auth');
    }
}
