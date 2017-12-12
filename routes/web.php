<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('log', function (\Faker\Generator $faker) {
//    $mongodb = \Illuminate\Support\Facades\DB::connection('mongodb');
//    $db = $mongodb->collection('products');
//    $db->insert([
//        'name'=>'Robot 3178',
//        'power'=>13098,
//        'age'=>384,
//        'birth_day'=>'2099-01-09',
//    ]);
//    dd($db->get());

//    $log = new \App\Monolog();
//    $log->name = 'Robot 31';
//    $log->save();

//    var_dump(app('request')->get('hi'));
    Log::notice($faker->name(), ['name'=>$faker->name()]);

});

Route::group(['prefix'=>'api'], function () {
    Route::group(['prefix'=>'logs'], function() {
        Route::get('/', 'MonologController@getAll');
    });
});


/** @var \Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
//    $api->get('/example/test', ['middleware'=>'auth'], 'App\Http\Controllers\ExampleController@test');
//    $api->get('/example/test', /*['middleware'=>'api.auth'],*/ 'App\Http\Controllers\ExampleController@test');

    /** @var \Dingo\Api\Routing\Router $api */
    $api->post('/test', \App\Http\Controllers\ExampleController::class.'@test');

    $api->get('test', function() {
        $rules = [
            'username' => ['required', 'alpha'],
            'password' => ['required', 'min:7']
        ];

        $payload = app('request')->only('username', 'password');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }

    });
});
