<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v2', 'middleware' => 'check.user.model'], function () {
    Route::post('login', 'Api\AuthController@login');

    Route::group(['middleware' => ['jwt.auth'/*, 'jwt.refresh'*/]], function () {

	    Route::get('token/refresh', 'Api\AuthController@refresh');

        Route::resource('orders', 'Api\Orders\OrderController');
        Route::resource('profile', 'Api\ProfileController');
//        Route::post('geo/set', 'Api\GeoController@set');
        Route::post('geo/set-list', 'Api\GeoController@setArray');
        Route::post('geo/get_route', 'Api\GeoController@getRoute');
        Route::get('geo/transportgps', 'Api\GeoController@getTransportGps');

        /* DOCUMENTS */
	    Route::post('documents', 'Api\Orders\DocumentController@getDocuments');

        Route::post('order-document', 'Api\Orders\DocumentController@create');
        Route::post('order-document/update/{id}', 'Api\Orders\DocumentController@update');
        Route::delete('order-document/{id}', 'Api\Orders\DocumentController@destroy');
        Route::get('download/{filename}', 'ImageController@download');

	    Route::get('order-document/signature/{doc_id}', 'Api\Orders\DocumentSignatureController@signature')->where('doc_id', '[0-9]+');

        /* NOTIFICATION */
        Route::post('/notification-send', 'Api\NotificationController@send');

        /* PROGRESS */
        Route::get('/progress/{orderId}', 'Api\Orders\ProgressController@getProgress');
        Route::post('/progress/{orderId}', 'Api\Orders\ProgressController@update');
        Route::post('/progress/{orderId}/{position}', 'Api\Orders\ProgressController@updatePosition');


        /* REPORTS */
	    Route::post('/report', 'Api\ReportController@getDriverStat');
	    Route::get('/report/expenses', 'Api\ReportController@getExpenses');
	    Route::post('/report/detail', 'Api\ReportController@getDriverExpenses');
	    Route::post('/report/update', 'Api\ReportController@update');
//	    Route::get('/report-fix', 'Api\ReportController@fix'); // TODO remove later

	    /* SIGNATURE */
	    Route::post('/signature', 'Api\Orders\DocumentSignatureController@index');
	    Route::post('/signature/check', 'Api\Orders\DocumentSignatureController@check');
	    Route::post('/signature/is_signed', 'Api\Orders\DocumentSignatureController@isSigned');


        /* LOGOUT */
        Route::get('logout', 'Api\AuthController@logout');

	    Route::match(['get', 'post'], '/{any}', 'Api\AuthController@need_to_update')->where('any', '.*');
    });
});

Route::group(['prefix' => 'v1', 'middleware' => 'check.user.model'], function () {
	Route::post('login', 'Api\AuthController@login');

	Route::group(['middleware' => ['jwt.auth']], function () {

		Route::resource('orders', 'Api\Orders\OrderController');
		Route::post('geo/set', 'Api\GeoController@set');
		Route::post('geo/set-list', 'Api\GeoController@setArray');
		Route::post('geo/get_route', 'Api\GeoController@getRoute');

		/* PROGRESS */
		Route::get('/progress/{orderId}', 'Api\Orders\ProgressController@getProgress');
		Route::post('/progress/{orderId}', 'Api\Orders\ProgressController@update');
		Route::post('/progress/{orderId}/{position}', 'Api\Orders\ProgressController@updatePosition');
		/* LOGOUT */
		Route::get('logout', 'Api\AuthController@logout');

		Route::match(['get', 'post'], '/{any}', 'Api\AuthController@need_to_update')->where('any', '.*');
	});
});