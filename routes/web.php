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

Artisan::call('view:clear');

Route::prefix('cron_acs1118')->group(function () {
	Route::get('/offers', 'CronController@clearOffers')->name('cron.clearOffers');
	Route::get('/order-to-active', 'CronController@orderToActive')->name('cron.orderToActive');
	Route::get('/payment-reminder', 'CronController@paymentReminder')->name('cron.payment.reminder');
});

// TODO test routes
Route::get('/test-pdf/{order_id?}/{user_id?}', 'TestController@index');

Route::group(['middleware' => ['web', 'language']], function () {

	Route::post('/address', 'Front\AddressController@index');

    /* Auth routes */
    Auth::routes();
    Route::post('/check/email', 'Auth\LoginController@checkEmail');
    Route::get('/profile/register', 'Auth\RegisterController@index')->name('register.home');
    Route::post('/profile/register', 'Auth\RegisterController@index')->name('register.home.post'); // for redirect from lending with address params
    Route::get('/profile/register/{account}', 'Auth\RegisterController@show')->where(['account' => 'client|logistic'])->name('register.account');
    Route::get('/profile/register/phone', 'Auth\RegisterController@registerPhone')->name('register.phone');

    // send email, sms
    Route::post('/profile/register/send/{type}', 'Auth\RegisterController@registerSend')->where(['type' => 'phone|email'])->name('register.send');

    Route::get('/verification/{token}', 'Auth\RegisterController@verification')->name('register.verification');

    Route::get('/invitation/{token}', 'Auth\InvitationController@showRegistrationForm');
    Route::get('/specializations/register/{user}', 'Auth\RegisterController@showSpecializationsForm')->name('specializations.form');
    Route::post('/specializations/register/{user}', 'Auth\RegisterController@addSpecializationsToUser')->name('specializations.register');

    /* User Activation */
    // TODO check in future version
    Route::get('/user/activation/{token}', 'Auth\RegisterController@activateUser')->name('user.activate');

    /* Feedback */
    Route::post('/feedback', 'Admin\FeedbackController@store')->name('feedback.store');
    /* Request test*/
    Route::post('/request-test', 'Admin\RequestTestController@store');

    /* Request for logistic API*/
    Route::any('/logistic/{name}', 'LogisticController@show');
    Route::post('/logistic/store', 'LogisticController@store');

    /* Location Globus */
    Route::get('globus/{id}/{name}/kml/', 'Location\LocationController@globusRouteLayerKml');

    Route::middleware(['UserCheck', 'isSubscribed', 'auth'])->group(function () {

		/* DICTIONARY */
	    /* Request for Countries, States, Cities */
	    Route::post('/dic/geodata', 'Dic\GeographerController@index')->name('dic.geodata');

        /* User pages */
        Route::get('/home', 'HomeController@index')->name('user.home');
        Route::get('/faq', 'HomeController@faq');
        Route::get('/setting', 'User\SettingController@index')->name('user.setting');
        Route::get('/profile/', 'User\ProfileController@index')->name('user.profile');
        Route::get('/profile/company/{id}', 'User\ProfileController@index')->name('user.profile.company');

        Route::resource('/staff', 'User\StaffController');
        Route::post('/staff/{id}/save', 'User\StaffController@save');

        Route::get('/drivers-free-ajax/{transportId}', 'DriverController@getFreeAjax');

        /* CLIENTS */
        Route::middleware('checkAccess:clients')->group(function () {
            Route::get('/clients', 'User\ClientController@index');
            Route::get('/clients/{id}/history', 'User\ClientController@history')->name('client.history');
            Route::get('/client-invite/{id}', 'User\ClientController@toInvite')->middleware('userIsLogistic');
            Route::post('/client-exists', 'User\ClientController@isExists');
            Route::resource('/client', 'User\ClientController');
            Route::post('/client/setmain', 'User\ClientController@setMainPhone')->name('client.phone.setmain');
        });

//        Partner
        Route::resource('/partner', 'User\PartnerController');
        Route::get('/partner-notification', 'User\PartnerController@notification')->name('user.partner.notification');
        Route::post('/partner-exists', 'User\PartnerController@isExists');

        /* ANALYTICS */
        Route::prefix('analytics')
             ->middleware('checkAccess:analytics')
             ->name('analytics.')
             ->group(function () {
            Route::get('', 'AnalyticsController@companies')->name('companies');
            Route::get('deals', 'AnalyticsController@deals')->name('deals');
            Route::get('logistics', 'AnalyticsController@logistics')->name('logistics');

            Route::get('drivers', 'Analytics\DriversController@index')->name('drivers');
            Route::post('drivers', 'Analytics\DriversController@updParameter')->name('drivers.upd');
//            Route::get('drivers/report', 'Analytics\DriversController@report')->name('analytics.drivers.report');
            Route::post('drivers/report', 'Analytics\DriversController@report')->name('drivers.report');

	        Route::match(['get', 'post'], 'transport', 'Analytics\TransportAnalyticController@index')->name('transport');

            Route::get('clients', 'AnalyticsController@clients')->name('clients');
            Route::get('finances', 'AnalyticsController@finances')->name('finances');
        });

        /* FINANCES */
        Route::prefix('finance')->middleware('checkAccess:finance')->group(function () {
            Route::get('', 'HomeController@finance')->name('finance.index');
        });

        /* Profile update */
        Route::post('/profile/photos', 'PagesController@profile_photos')->name('user.profile.photos');
        Route::post('/profile/documents', 'PagesController@profile_documents')->name('user.profile.documents');
        Route::get('/documents-list/', 'DocumentController@index')->name('documents.index');
//        Route::post('/documents-list/store', 'DocumentController@store')->name('documents.store');

        /* Dashboard pages */
        Route::get('dashboard', 'User\DashboardController@indexDashboard')->name('user.dashboard');

	    Route::prefix('documents-list')->group(function () {
		    Route::get('template-edit/{id}', 'DocumentController@templateEdit')->name('documents.template.edit');
		    Route::post('template-edit/store', 'DocumentController@store')->name('documents.template.store');
		    Route::get('preview/{doc_id}', 'DocumentController@previewStoredDocument')->name('documents.preview.stored');
		    Route::match(['get', 'post'], 'template-preview/{id}', 'DocumentController@templatePreview')->name('documents.download_document_template');
//		    Route::get('{id}/{document_item}', 'DocumentController@downloadDocument')->name('documents.download_document');

		    // Upload Sign
		    Route::post('graph-sign-save', 'DocumentController@ajaxSaveGraphSign')->name('documents.save_graph_sign');
		    Route::post('scan-sign-save', 'DocumentController@ajaxSaveScanSign')->name('documents.save_scan_sign');

		    Route::get('download/{filename}', 'ImageController@download')->name('documents.download');
		    Route::get('document/preview/{filename}', 'DocumentController@previewDocument')->name('documents.preview');
		    Route::delete('document/{id}', 'DocumentController@destroy')->name('documents.destroy');
	    });


//        Route::post('/documents-form/{form_id}/', 'DocumentController@updateForm')->name('documents.form.update');
//        Route::post('/profile/update', 'pagesController@profile_update')->name('user.profile.update');
        Route::post('/profile/update', 'User\SettingController@update')->name('user.profile.update');
        Route::post('/profile/images/add', 'ImageController@upload_images')->name('images.update');
        Route::post('/profile/email/reactivate', 'AuthController@reactivate_email')->name('user.profile.email.reactivate');
        Route::get('/profile/password/accept/{token}', 'AuthController@password_accept')->name('user.password.accept');

		Route::get('/mailer', 'MailerController@index')->name('mailer.index');
		Route::get('/mailer/folder/{folder}', 'MailerController@index')->name('mailer.folder');
		Route::get('/mailer/message/{folder}/{message}', 'MailerController@message')->name('mailer.message.show');
		Route::get('/mailer/new', 'MailerController@newMessage')->name('mailer.message.new');
		Route::get('/mailer/attachment/{folder}/{message}/{attachment}', 'MailerController@attachment')->name('mailer.message.attachment');
		Route::post('/mailer/send', 'MailerController@send')->name('mailer.send');
		Route::post('/mailer/settings', 'MailerController@saveSettings')->name('mailer.settings.update');

        /* TRANSPORT */
        Route::prefix('transport')->middleware('checkAccess:transport')->group(function () {
            Route::get('delete-image/{id}', 'TransportController@deleteImage');
            Route::get('attach/{orderId}/{transportId}', 'Transport\AttachOrDetachController@order');
            Route::post('category', 'Transport\CategoryController@getTypeOrRollingStock');
            Route::get('{transport_id}/sendSMS', 'TransportController@sendSMS');
        });
        Route::resource('/transport', 'TransportController', ['middleware' => ['checkAccess:transport']]);

        Route::middleware('checkAccess:transport')->group(function () {
            Route::post('/transport-list', 'TransportController@getAvailable');
            Route::post('/transport-update-ajax', 'TransportController@updateAjax');
            Route::post('/transport-own', 'TransportController@storeOwn');
        });


        /* ORDERS */
        Route::middleware(['verify.user'])->group(function () {

            Route::get('qr-code/order/qr-code-{order_id}.svg', 'HomeController@qrCodeOrder')->name('qr.order');

            //        Route::get('/orders', 'OrderController@orders')->name('orders');
            Route::get('/orders', 'OrderController@index')->name('orders')/*->middleware('setTypeRole')*/;
            Route::post('/orders', 'OrderController@index')->name('orders.filters')/*->middleware('setTypeRole')*/;
            Route::get('/requests', 'OrderController@index')->name('requests')->middleware('userIsLogistic');
            Route::get('/order/{id}', 'OrderController@show')->name('orders.show');
            Route::post('/order/{id}', 'OrderController@update')->name('orders.update');
            Route::get('/order-create', 'OrderController@create')->name('order.create')->middleware('checkSubscription:order_creating');;
            Route::post('/order-store', 'OrderController@store')->name('order.store');
            Route::post('/order-action', 'OrderController@activateOrRejection')->name('orders.action');
            //Route::get('/map', 'User\MapController@index')->name('map.show');
            Route::get('ajax/route/{order}', 'Location\LocationController@getRouteOrder')->name('map.route.ajax');
            Route::get('ajax/helper/set/{helper}', 'User\ProfileController@set_helper');
//            Route::get('order-partner-change/{id}/{check}', 'OrderController@partnerChange');
            Route::get('order-partner-approved/{id}/{executor}', 'OrderController@partnerApproved')->name('order.partner.approved');
//            Route::post('/additional-loading/{orderId}', 'Order\PerformerController@updateAdditionalLoading');

            /* PROGRESS */
            Route::put('/progress/{orderId}', 'Order\ProgressController@update');
            /* TEMPLATES */
            Route::get('/templates/{id}', 'Order\TemplateController@show');

            /* LIKED */
            Route::get('/order-like/{orderId}/{like}', 'Order\LikeController@likeOrDislikeOrder');

            /* DOCUMENTS */
            Route::post('/order-document/', 'Order\DocumentController@create');
            Route::post('/order-document/{imageId}', 'Order\DocumentController@update');


            /* OFFER */
            Route::get('/offer/repeat/{orderId}', 'OfferController@repeatRequest')->name('offer.repeat');
            Route::get('/offer/{orderId}/{executorId}', 'OfferController@agree')->name('offer.agree');
            Route::post('/offer', 'OfferController@store')->name('offer.store');


//            Route::get('globus/route-kml', 'Location\LocationController@getGlobusRouteKml');
        });

        /* LOCATION */
        Route::prefix('location')->name('location.')->group(function () {
            Route::get('/', 'Location\LocationController@index')->name('index');
            Route::post('/', 'Location\LocationController@position')->name('position');
            Route::get('search_number', 'Location\LocationController@search_number')->name('search_number');
            Route::get('search_data', 'Location\LocationController@search_data')->name('search_data');
            Route::post('ajax', 'Location\LocationController@ajaxRequests')->name('ajax');
            Route::post('route', 'Location\LocationController@getRouteTransport')->name('route');
            Route::get('globus', 'Location\LocationController@globus')->name('globus');
        });


        /* Phone activation ajax */
        Route::post('/ajax/phone/activate', 'PhoneController@send_activation_sms_ajax')->name('phone.activate');
        Route::post('/ajax/phone/code', 'PhoneController@check_code_sms_ajax')->name('phone.code');

        /* Specializations ajax routes*/
//        Route::post('/ajax/sp/get', 'Specialization@get_ajax')->name('sp.get.ajax');
        Route::post('/ajax/sp/get', 'SpecializationController@getAjax')->name('sp.get.ajax');
//        Route::post('/ajax/sp/save', 'SpecializationController@save_ajax')->name('sp.save.ajax');
        Route::post('/ajax/sp/save', 'SpecializationController@saveAjax')->name('sp.save.ajax');

        /* add cc ajax */
        Route::post('/ajax/cc/add', 'CcardController@add_cc_ajax')->name('cc.add.ajax');
        Route::post('/ajax/cc/edit', 'CcardController@edit_cc_ajax')->name('cc.edit.ajax');
        Route::post('/ajax/cc/remove', 'CcardController@remove_cc_ajax')->name('cc.remmove.ajax');

        //----- ADDRESS -----
        Route::get('address/autocomplete', 'AddressController@autocomplete');
        Route::get('address/details', 'AddressController@placeDetails');

        Route::prefix('pay')->middleware('checkAccess:pay')->group(function () {
            Route::get('', 'PaymentController@index')->name('pay.index');
            Route::post('subscription/get', 'PaymentController@getById')->name('pay.subscription.get');
            Route::get('subscription/{id}', 'PaymentController@show')->name('pay.subscription.show');

            // TODO Test ONLY
            Route::get('subscription/change/{planid}/{userid?}', 'PaymentController@change')->name('pay.subscription.change');

            /* LiqPay */
            Route::post('liqpay', 'PaymentController@postPaymentWithLiqPay')->name('pay.liqpay.pay');;
            Route::post('liqpay/formparams', 'PaymentController@getParamForFormLiqPay')->name('pay.liqpay.form.params.pay');
            Route::post('liqpay/cancel', 'PaymentController@getLiqPayCancel')->name('pay.liqpay.cancel');

        });

	    /* Contacts */
	    Route::get('contacts', 'HomeController@contacts')->name('contacts.index');
	    /* Upgrade System page Feedback*/
	    Route::get('improve', 'HomeController@improveSystem')->name('improve.index');
	    Route::post('improve', 'HomeController@improveSubmit')->name('improve.submit');
	    /* Test Design*/
	    Route::get('design', 'HomeController@design')->name('innlogist.design');

	    /* Opendata systems*/
	    Route::post('/opendata/opendatabot', 'OpenDataController@getOpendatabotInfo')->name('opendata.opendatabot');
    });
    /* LiqPay CallBack */
    Route::post('pay/liqpay/callback', 'PaymentController@callbackLiqPay')->name('pay.liqpay.callback');

    /* Social user login */
    Route::get('/login-social/{provider}/{role?}', 'SocialController@redirectToProvider')->name('social.login');
    Route::get('/login/social/callback/{provider}', 'SocialController@handleProviderCallback')->name('social.callback');

    /* User Notifications */
	Route::get('/notification/check', 'NotificationController@check')->name('notification.check');
    Route::get('/notification/{id}', 'NotificationController@show')->name('notification.show');
    Route::delete('/notification/{id}', 'NotificationController@destroy');

    /* Admin routes */
    Route::prefix('admin')->group(function () {

        /* Admin auth */
        Route::get('', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
        Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login.form');
        Route::post('login', 'AdminAuth\LoginController@login');
        Route::get('logout', 'AdminAuth\LoginController@logout');

        /* Reset password */
        Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset');
        Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
        Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('admin.password.reset');
        Route::post('password/change', 'Auth\ChangePasswordController@index')->name('password.change');

        /* Inside admin panel routes */
        Route::get('/home', 'AdminController@index')->name('admin.home');

//        Route::get('/users/role/{role_id}/', 'AdminController@users_role')->name('admin.users.role');
        Route::get('/users/role/{roleName}/', 'AdminController@usersRole')->name('admin.users.role');
//        Route::get('/users/type/{type}/', 'AdminController@users_type')->name('admin.users.type');
        Route::get('/users/{type}/', 'AdminController@usersType')->name('admin.users.type');
        Route::get('/users/requests/', 'AdminController@requests')->name('admin.users.requests');
        Route::post('/users/{user_id}/update', 'AdminController@update_user')->name('admin.users.update');
        Route::post('/users/{user_id}/block', 'AdminController@block')->name('admin.users.block');
        Route::post('/users/{user_id}/delete', 'AdminController@delete')->name('admin.users.delete');
//        Route::get('/users/{user_id}/', 'AdminController@view_user')->name('admin.users.view');
        Route::get('/user/{user}/', 'AdminController@showUser')->name('admin.user.get');

        Route::resource('/instructions', 'Admin\InstructionsController');
    });

    /* Home controller */
    Route::get('/{lang?}', 'PagesController@homePage')->name('homepage')->where('lang', 'ru|en');
    Route::post('/landing/feedback', 'FeedbackController@landingFeedback')->name('feedback.landing');
    Route::get('/carrier/{lang?}', 'PagesController@homePageCarrier')->name('homepage.carrier');
    Route::get('/privacy', 'PagesController@privacy')->name('page.privacy');
    Route::get('/terms', 'PagesController@terms')->name('page.terms');
    Route::get('/privacy_app', 'PagesController@privacyApp')->name('page.privacy_app');

	// page errors
	Route::get('404', 'ErrorController@notfound')->name('page404');

    
    Route::get('/optimizetest', 'OptimizeGeoController@optimizaTest')->name('optimiza_test');
    Route::get('/optimizeonline/{order_id}', 'OptimizeGeoController@optimizaOnlineGeoById')->name('optimiza_online_geo_by_id');
    Route::get('/optimize/{order_id}', 'OptimizeGeoController@optimizaGeoById')->name('optimiza_geo_by_id');
    Route::get('/optimize', 'OptimizeGeoController@optimizageo')->name('optimizageo');
//    Route::post('pay/liqpay/callback', 'PaymentController@postPaymentWithLiqPayCallback')->name('pay.liqpay.callback');;

    /* language */
    Route::post('/language', array(
        'Middleware' => 'LanguageSwitcher',
        'uses'       => 'LanguageController@index',
    ));

});
