<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use App\Components\Helpers\ResponseHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if(request()->expectsJson()){
                // NOT FOUND EXCEPTION
                if($e instanceof NotFoundHttpException){

                    // MODEL NOT FOUND EXCEPTION - PREVIOUS NOT FOUND
                    if($e->getPrevious() instanceof ModelNotFoundException){
                        return ResponseHelper::sendError(trans('Data does not exist with the given id'));
                    }

                    return ResponseHelper::sendError(trans('Your request is not available, please check again'));
                }

                // VALIDATION EXCEPTION
                if($e instanceof ValidationException){
                    return ResponseHelper::sendError(trans('Unexpected error. Try again later'), $e);
                }

                // AUTHENTICATION EXCEPTION
                if($e instanceof AuthenticationException){
                    return ResponseHelper::sendError(trans('Unauthenticated'), [], 401);
                }

                // AUTHORIZATION EXCEPTION
                if($e instanceof AuthorizationException){
                    return ResponseHelper::sendError(trans('You do not have the right access for this request'), [], 401);
                }

                // MODEL NOT FOUND EXCEPTION
                if($e instanceof ModelNotFoundException){
                    return ResponseHelper::sendError(trans('Data does not exist with the given id'));
                }

                // QUERY EXCEPTION
                if($e instanceof QueryException){
                    if(env('QUERY_EXCEPTION_DEBUG', 'off') == 'off')
                        return ResponseHelper::sendError(trans('Something went wrong on database'));
                }

            }
        });

    }
}
