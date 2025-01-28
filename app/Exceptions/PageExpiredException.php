<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class PageExpiredException extends Exception
{
    public function render($request, Throwable $exception): RedirectResponse | JsonResponse
    {
        $payload = [
            'message' => 'Page expired, please try again',
        ];

        return $request->expectsJson()
            ? response()->json($payload, Response::HTTP_BAD_REQUEST)
            : redirect()->back()->notify($payload['message'], 'error');
    }

    public static function within(Response | RedirectResponse | JsonResponse $response): bool
    {
        return $response->getStatusCode() === Response::HTTP_BAD_REQUEST;
    }
}
