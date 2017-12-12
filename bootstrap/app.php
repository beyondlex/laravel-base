<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->configureMonologUsing(function($monolog){
    /** @var \Monolog\Logger $monolog */
    $monolog->pushHandler(new \App\Extensions\MongoDBHandler());
    $monolog->pushProcessor(new \Monolog\Processor\IntrospectionProcessor(null,
        [
            'Illuminate\\Foundation\\Http\\Kernel',
            'Illuminate\\Log',
            'Illuminate\\Support\\Facades',
        ]));
    $monolog->pushProcessor(function($record) {
        if ($req = app('request')->all()) {
            $record['extra']['request'] = $req;
        }
        return $record;
    });
    $webProcessor = new \Monolog\Processor\WebProcessor();
    $webProcessor->addExtraField('user_agent', 'HTTP_USER_AGENT');
    $monolog->pushProcessor($webProcessor);
    return $monolog;

});

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
