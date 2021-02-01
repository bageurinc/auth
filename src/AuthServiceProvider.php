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
        $this->app->make('Bageur\Auth\controller\PasswordResetController');
        $this->app->make('Bageur\Auth\controller\UserController');
        $this->app->make('Bageur\Auth\controller\AuthController');
        $this->app->make('Bageur\Auth\controller\MenuController');
        $this->app->make('Bageur\Auth\controller\LevelController');
        $this->app->make('Bageur\Auth\controller\MenuActionController');
        $this->app->make('Bageur\Auth\controller\PerkakasController');
       
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
