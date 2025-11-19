<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionHandler
{
    public static function handle(Throwable $exception, Request $request)
    {
        if ($exception instanceof ApiException) {
            return errorResponse($exception->getMessage(), $exception->getStatus());
        }

        if ($exception instanceof ValidationException) {
            return errorResponse($exception->getMessage(), 422, ['errors' => $exception->errors()]);
        }

        if ($exception instanceof ModelNotFoundException) {
            return errorResponse("Data not found.", 404);
        }

        if ($exception instanceof NotFoundHttpException) {
            return errorResponse("Resource not found.", 404);
        }

        if ($exception instanceof NotFoundException) {
            return errorResponse("Resource not found.", 404);
        }

        if ($exception instanceof AuthenticationException) {
            return errorResponse("Unauthenticated", 401);
        }

        $data['exception'] = get_class($exception);
        $data['line'] = $exception->getLine();
        $data['file'] = $exception->getFile();
        $data['code'] = $exception->getCode();
        $data['trace'] = $exception->getTrace();

        if (config('app.debug')) {
            return errorResponse($exception->getMessage(), 500, $data);
        }

        $formatted = sprintf(
            "*Exception:* %s\n*Message:* %s\n*File:* %s:%d\n*Status Code:* %s",
            $data['exception'],
            $exception->getMessage(),
            $data['file'],
            $data['line'],
            $data['code']
        );

        return errorResponse('Something went wrong', 500);
    }
}
