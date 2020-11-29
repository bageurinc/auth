# Gini Installnya

ini untuk cms bageur ya :).
jangan lupa plugin ini butuh
[JWT AUTH](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/)

## Installation
1.install bageur auth
```bash
composer require bageur/auth
```
2.vendor:publish
```bash
 php artisan vendor:publish --tag=bageur-auth --force
```
3.setup vendor ke 3
bisa langsung baca [disni](https://github.com/laravolt/avatar)

## Usage
1.config/auth.php  
```php
	'defaults' => [
	        'guard' 	=> 'api',
	        'passwords' => 'bgr_users',
	    ],

	'guards' => [
	        ..................
	        'api' => [
	             'driver' => 'jwt',
	             'provider' => 'bgr_users',
	        ],
	    ],
	'providers' => [
	        ..................     
	        'bgr_users' => [
	            'driver' => 'eloquent',
	            'model' => Bageur\Auth\model\user::class,
	        ],
		],
	'passwords' => [
	        ..................     
	        'bgr_users' => [
            'provider' => 'bgr_users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
	        ],
	    ],
```
2.app/Http/Kernel.php
```php
	 protected $routeMiddleware = [
	 	.................. 
	 	'bgr.verify' => \App\Http\Middleware\BageurMiddleware::class,
	 ];
```
3.config/cors.php  
```php
	 return [
	 	.................. 
	 	'paths' => ['api/*','bageur/*'],
	 ];
```
4.routes/api.php  
```php
	Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1','middleware' => 'bgr.verify'], function () {
		
	});
});
```
5.config/database.php   
```php
'connections' => [
			.................. 
	'mysql' => [
				..................     
				'strict' => false,
				'engine' => null,
				'options' => extension_loaded('pdo_mysql') ? array_filter([
					PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
					PDO::ATTR_EMULATE_PREPARES => true
				]) : [],
			],
		],
```
5. config/app.php

```php
'providers' => [
	..................
        Bageur\Auth\AuthServiceProvider::class,
        Bageur\Company\CompanyServiceProvider::class
    ],
'aliases' => [
		 'Bageur' => Bageur\Auth\Facades\BageurFacade::class
],
```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)