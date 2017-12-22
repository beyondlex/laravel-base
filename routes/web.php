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
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FaceController;
use App\Http\Controllers\SignInController;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});


/** @var \Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

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

		//签到
		$api->post('signin', SignInController::class.'@signIn');//签到
		$api->get('signin', SignInController::class.'@getSignInList');//签到列表
		$api->get('signin/{id}', SignInController::class.'@getSignInInfo');//签到详情
		$api->put('signin/{id}', SignInController::class.'@updateSignInInfo');//更新签到

		//company
		$api->post('companies', CompanyController::class.'@create');
		$api->get('companies', CompanyController::class.'@all');
		$api->get('companies/{id}', CompanyController::class.'@find');
		$api->put('companies/{id}', CompanyController::class.'@update');
		$api->delete('companies/{id}', CompanyController::class.'@delete');

		//department
		$api->post('departments', DepartmentController::class.'@create');
		$api->get('departments', DepartmentController::class.'@all');
		$api->get('departments/{id}', DepartmentController::class.'@find');
		$api->put('departments/{id}', DepartmentController::class.'@update');
		$api->delete('departments/{id}', DepartmentController::class.'@delete');




    });

});

////多媒体广告
//Route::get('/api/ads', function() {return 'hi';});//列表
//Route::get('/api/ads/{id}', 'AdController@one');//详情
//Route::post('/api/ads', 'AdController@create');//新增
//Route::put('/api/ads/{id}', 'AdController@update');//更新
//Route::delete('/api/ads/{id}', 'AdController@delete');//删除

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