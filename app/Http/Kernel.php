<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\LanguageSwitcher::class,
            \App\Http\Middleware\CheckOrderTestimonial::class,
	        \App\Http\Middleware\CheckTutorials::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
	        \App\Http\Middleware\SetAuthProviders::class,
            \App\Http\Middleware\JwtCheckDevice::class,
//            \App\Http\Middleware\JwtRefresh::class,

        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'             => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'         => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'              => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'            => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'Admin'            => \App\Http\Middleware\Admin::class,
        'UserCheck'        => \App\Http\Middleware\Authenticate::class,
        'userIsLogistic'   => \App\Http\Middleware\UserIsLogistic::class,
        'setTypeRole'      => \App\Http\Middleware\SetTypeRole::class,
        'verify.user'      => \App\Http\Middleware\VerifyUser::class,
        'check.user.model' => \App\Http\Middleware\SetAuthProviders::class,
        'checkAccess'      => \App\Http\Middleware\CheckAccess::class,
	    'isSubscribed'     => \App\Http\Middleware\isSubscribed::class,
	    'checkSubscription'=> \App\Http\Middleware\CheckSubscription::class,
//        'jwt.auth'         => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
//        'jwt.refresh'      => \Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
//        'jwt.refresh'      => \App\Http\Middleware\JwtRefresh::class,
    ];
}
