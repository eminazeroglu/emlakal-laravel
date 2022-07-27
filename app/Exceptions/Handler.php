<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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


    public function render($request, Throwable $e): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        $local   = \App::environment('local');
        $code    = $e->getCode() > 0 && $e->getCode() < 500 ? $e->getCode() : 400;
        $message = $e->getMessage();

        if ($local):
            $message = ['message' => $e->getMessage()];
            if ($e->getPrevious()) $message['previous'] = $e->getPrevious();
            if ($e->getLine()) $message['line'] = $e->getLine();
            if ($e->getFile()) $message['file'] = $e->getFile();
        endif;

        if (get_class($e) === AuthenticationException::class):
            $code = 401;
        elseif (get_class($e) === NotFoundHttpException::class):
            $code = 404;
            if ($local) $message['message'] = 'Route does not exist';
            else $message = 'Route does not exist';
        elseif (get_class($e) === ModelNotFoundException::class):
            $code = 404;
            if ($local) $message['message'] = 'Data not found';
            else $message = 'Data not found';
        endif;

        if ($request->expectsJson() || str(request()->path())->startsWith('api')):
            return response()->json($message, $code);
        endif;

        return parent::render($request, $e);
    }
}
