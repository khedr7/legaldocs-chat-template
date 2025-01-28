<?php

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class TooManyRequestsException extends Exception
{
    public function render($request, Throwable $exception): RedirectResponse|JsonResponse
    {
        $payload = [
            'message' => 'Too many attempts, please wait a minute',
        ];

        return $request->expectsJson()
            ? response()->json($payload, Response::HTTP_TOO_MANY_REQUESTS)
            : back()->notify($payload['message'], 'error');
    }

    public static function within(Response | RedirectResponse | JsonResponse $response): bool
    {
        return $response->getStatusCode() === Response::HTTP_TOO_MANY_REQUESTS;
    }
}
