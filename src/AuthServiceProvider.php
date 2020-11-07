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
        $this->app->make('Bageur\Auth\UserController');
        $this->app->make('Bageur\Auth\AuthController');
        $this->app->make('Bageur\Auth\MenuController');
        $this->app->make('Bageur\Auth\LevelController');
        $this->app->make('Bageur\Auth\MenuActionController');
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migration');
        // $this->publishes([
        //     __DIR__.'/config/auth.php' => config_path('auth.php'),
        //  ]);       
         $this->publishes([
            __DIR__.'/middleware/JwtMiddleware.php' => app_path('http/Middleware/JwtMiddleware.php'),
         ],'JwtMiddleware');         
         // $this->publishes([
         //    __DIR__.'/middleware/Kernel.php' => app_path('http/Kernel.php'),
         // ]);
    }
}
