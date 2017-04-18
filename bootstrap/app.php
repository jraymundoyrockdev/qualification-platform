<?php

use Doctrine\DBAL\Types\Type;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->withFacades();

//$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    \Vluzrmos\LumenCors\CorsMiddleware::class
]);

$app->routeMiddleware([
    'validate-json-schema' => App\Http\Middleware\ValidateJsonSchemaMiddleware::class,
    'jwt-auth' => App\Http\Middleware\ValidateJWTMiddleware::class,
    'jwt-refresh' => App\Http\Middleware\RefreshJWTMiddleware::class
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(LaravelDoctrine\ORM\DoctrineServiceProvider::class);
$app->register(LaravelDoctrine\Migrations\MigrationsServiceProvider::class);
$app->register(App\Providers\RepositoryServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class);
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__ . '/../routes/web.php';
});

if (!class_exists('EntityManager')) {
    class_alias('LaravelDoctrine\ORM\Facades\EntityManager', 'EntityManager');
}

if (!class_exists('Registry')) {
    class_alias('LaravelDoctrine\ORM\Facades\Registry', 'Registry');
}

if (!class_exists('Doctrine')) {
    class_alias('LaravelDoctrine\ORM\Facades\Doctrine', 'Doctrine');
}

if (!class_exists('JWTAuth')) {
    class_alias('Tymon\JWTAuth\Facades\JWTAuth', 'JWTAuth');
}

if (!class_exists('JWTFactory')) {
    class_alias('Tymon\JWTAuth\Facades\JWTFactory', 'JWTFactory');
}

if (!Type::hasType('uuid')) {
    Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
}

$app->configure('jwt');

return $app;
