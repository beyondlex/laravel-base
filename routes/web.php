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




/** @var \Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
//    $api->get('/example/test', ['middleware'=>'auth'], 'App\Http\Controllers\ExampleController@test');
//    $api->get('/example/test', /*['middleware'=>'api.auth'],*/ 'App\Http\Controllers\ExampleController@test');

    /** @var \Dingo\Api\Routing\Router $api */

    $api->group(['prefix'=>'api'], function () use ($api) {
        $api->group(['prefix'=>'logs'], function() use ($api) {
            $api->get('/', \App\Http\Controllers\MonologController::class.'@getAll');
        });

        $api->get('ads', \App\Http\Controllers\AdController::class.'@all');
    });

    $api->post('/test', \App\Http\Controllers\ExampleController::class.'@test');

    $api->get('test', function() {
        $rules = [
            'username' => ['required', 'alpha'],
            'password' => ['required', 'min:7']
        ];

        $messages = [
            'username.required'=>'username 不能为空'
        ];

        $payload = app('request')->only('username', 'password');

        $validator = app('validator')->make($payload, $rules, $messages);

        if ($validator->fails()) {
            throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }

    });
});
