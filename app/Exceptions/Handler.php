<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
//use GrahamCampbell\Exceptions\ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
	    \Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

	    if ($this->isHttpException($exception)) {
		    if ($exception->getStatusCode() == 404) {
			    return redirect()->route('page404');
		    }
	    }

	    if($exception instanceof  \Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException){
		    innlogger('Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException');
	    }

	    if($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
		    return response()->json(["error" => $exception->getMessage()], 401);
	    }

        // if order.store page was opened too long

        $csrf = ['order.store', ];

        if($exception instanceof  \Illuminate\Session\TokenMismatchException && $request->ajax() && in_array($request->route()->getName(), $csrf) ){
            return response()
                ->json(['status' => 'TokenMismatchException', 'title' => '', 'text' => trans('auth.csrf')]);
        }

        if ($exception instanceof  \Illuminate\Session\TokenMismatchException && !$request->ajax()) {
            return redirect('/');
        }

	    if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
		    return redirect()->route('homepage');
	    }

        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return redirect()->route('orders');
        }

        if ($exception instanceof  \Illuminate\Validation\ValidationException && $request->ajax()) {
            return response()->json($exception->validator->getMessageBag()->toArray(), 422);
        }

        if ($exception instanceof  \Illuminate\Validation\ValidationException && !$request->ajax()) {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($exception->validator->getMessageBag());
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
