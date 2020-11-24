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
 php artisan vendor:publish --tag=bageur-auth
```
Pilih Tag : Bageur-auth

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
	 	'jwt.verify' => \App\Http\Middleware\JwtMiddleware::class,
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
	Route::group(['prefix' => 'bageur/v1','middleware' => 'jwt.verify'], function () {
		
	});
});
```
4.config/database.php  
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
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)