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

use App\Http\Controllers\AdController;
use App\Http\Controllers\FaceController;
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

Route::post('file', function() {
//	echo asset('storage/file.txt');
	$request = app('request');
	dd(pathinfo($request->file('file')->getClientOriginalName()));
//	Storage::disk('public')->put('file.txt', 'hello');
	$path = $request->file('file')->store('avatar', 'public');
	return [
		Storage::disk('public')->size($path),
		Storage::disk('public')->mimeType($path),
		$path,
	];
//	$path = Storage::disk('public')->putFile('dir', $request->file('file'));
//	return $path;
//	Storage::disk('public')->move('dir/GQytEX649pi6AlRPPJetBhc6JrVbpM0pGBdMXATW.jpeg', 'avatar/1.jpeg');
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

        //多媒体广告
        $api->get('ads', AdController::class.'@all');//列表
        $api->get('ads/{id}', AdController::class.'@one');//详情
        $api->post('ads', AdController::class.'@create');//新增
        $api->put('ads/{id}', AdController::class.'@update');//更新
        $api->delete('ads/{id}', AdController::class.'@delete');//删除

		//人脸
        $api->post('faceset', FaceController::class.'@createFaceSet');//创建人脸库
		$api->delete('faceset/{id}', FaceController::class.'@deleteFaceSet');//删除人脸库
		$api->get('faceset/{id}', FaceController::class.'@faceSet');//人脸库详情
		$api->post('faceset/{id}/face', FaceController::class.'@addFace');//添加人脸数据
		$api->delete('faceset/{id}/face/{face_oken}', FaceController::class.'@removeFace');//抹除人脸数据
        $api->post('faceset/{id}/actions/search', FaceController::class.'@searchFace');//匹配人脸
    });

//    $api->post('/test', \App\Http\Controllers\ExampleController::class.'@test');

//    $api->get('test', function() {
//        $rules = [
//            'username' => ['required', 'alpha'],
//            'password' => ['required', 'min:7']
//        ];
//
//        $messages = [
//            'username.required'=>'username 不能为空'
//        ];
//
//        $payload = app('request')->only('username', 'password');
//
//        $validator = app('validator')->make($payload, $rules, $messages);
//
//        if ($validator->fails()) {
//            throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
//        }
//
//    });
});
