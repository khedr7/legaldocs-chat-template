<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;



// laravel handler
class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}



// class Handler extends ExceptionHandler
// {

//     protected $levels = [
//         //
//     ];

//     protected $dontReport = [
//         //
//     ];

//     protected $dontFlash = [
//         'current_password',
//         'password',
//         'password_confirmation',
//     ];

//     public function register(): void
//     {
//         $this->reportable(function (Throwable $e) {
//             //
//         });
//     }

//     public function render($request, Throwable $e)
//     {
//         $code =  $e->getCode();
//         $msg  =  $e->getMessage();

//         if ($e instanceof UnauthorizedException) {
//             $code =  403;
//         } else if ($e instanceof ValidationException) {
//             $msg = $e->validator->errors()->first();
//             $code = 400;
//         } else if ($e instanceof NotFoundHttpException) {
//             $code = 404;
//             $msg = 'Route not found';
//         } else if ($e instanceof AuthenticationException) {
//             $code = 403;
//             $msg = 'UnAuthenticated';
//         } else if ($e instanceof ModelNotFoundException) {
//             $code = 403;
//             $msg = 'Model not found';
//         }


//         if (!$code || $code > 599 || $code <= 0 || gettype($code) !== "integer") {
//             $code = 500;
//         }

//         return response()->json([
//             'status' => 'Error',
//             'message' => $msg,
//             'model' => NULL,
//             'list' => NULL,
//             'returnedCode' => $code
//         ], $code);
//     }
// }


