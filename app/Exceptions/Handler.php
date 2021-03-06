<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'message' => 'Model not found',
                        'original_error_message' => $e->getMessage(),
                    ], 404);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'Validation failed',
                        'errors' => $e->errors()
                    ], 400);
                }

                if ($e instanceof SkillNotFoundException) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ], 500);
                }

                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
        });
    }
}
