# Gini Installnya

ini untuk cms bageur ya :).
jangan lupa plugin ini butuh JWT
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
```
2.app/Http/Kernel.php
```php
	 protected $routeMiddleware = [
	 	.................. 
	 	'jwt.verify' => \App\Http\Middleware\JwtMiddleware::class,
	 ];
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)