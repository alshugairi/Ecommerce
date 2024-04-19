<?php

namespace App\Packages\Emerald\Exceptions;

use App\Packages\Emerald\HttpFoundation\Response;
use Illuminate\{Auth\AuthenticationException,
    Contracts\Foundation\Application,
    Database\Eloquent\ModelNotFoundException,
    Http\JsonResponse,
    Http\Request,
    Validation\ValidationException
};
use Symfony\{Component\HttpFoundation\Exception\BadRequestException,
    Component\HttpKernel\Exception\MethodNotAllowedHttpException,
    Component\HttpKernel\Exception\NotFoundHttpException
};
use Throwable;

trait ExceptionHandlerTrait
{

    protected array $errors = [];

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Throwable $exception): JsonResponse
    {
        switch (true) {
            case $this->isModelNotFoundException($exception):
                $retrieve = $this->returnJSONResponse('Invalid Data Or Not Found (isModelNotFoundException)', 404);
                break;
            case $this->NotFoundException($exception):
                $retrieve = $this->returnJSONResponse('404 Not Found (NotFoundException)', 404);
                break;
            case $this->isValidationException($exception):
                $this->errors = $exception->errors();
                $retrieve = $this->returnJSONResponse($exception->getMessage(), 422);
                break;
            case $this->AuthenticationException($exception):
                $retrieve = $this->returnJSONResponse($exception->getMessage(), 401);
                break;
            case $this->isMethodNotAllowedException($exception):
                $retrieve = $this->returnJSONResponse($exception->getMessage(), 405);
                break;
            case $this->isBadRequestException($exception):
                $retrieve = $this->returnJSONResponse($exception->getMessage(), 400);
                break;
            default:
                $retrieve = $this->returnJSONResponse($exception->getMessage(), 400);
        }

        return $retrieve;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    protected function isModelNotFoundException(Throwable $exception): bool
    {
        return $exception instanceof ModelNotFoundException;
    }

    /**
     * @param $message
     * @param $statusCode
     * @return JsonResponse
     */
    protected function returnJSONResponse($message, $statusCode): JsonResponse
    {
        return response()->json(['status' => $statusCode, 'message' => $message ?: '', 'errors' => $this->errors], $statusCode, ['Access-Control-Allow-Origin' => '*'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    protected function NotFoundException(Throwable $exception): bool
    {
        return $exception instanceof NotFoundHttpException;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    protected function isValidationException(Throwable $exception): bool
    {
        return $exception instanceof ValidationException;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    protected function AuthenticationException(Throwable $exception): bool
    {
        return $exception instanceof AuthenticationException;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    protected function isMethodNotAllowedException(Throwable $exception): bool
    {
        return $exception instanceof MethodNotAllowedHttpException;
    }

    /**
     * @param Throwable $exception
     * @return bool
     */
    protected function isBadRequestException(Throwable $exception): bool
    {
        return $exception instanceof BadRequestException;
    }

    /**
     * @param $message
     * @param $statusCode
     */
    protected function returnHTTPMessage($message, $statusCode): void
    {
        abort($statusCode, $message);
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return Response|Application|mixed
     */
    protected function getHTTPResponseForException(Request $request, Throwable $exception): mixed
    {
        switch (true) {
            case $this->isModelNotFoundException($exception):
                $this->returnHTTPMessage('Invalid Data Or Not Found (isModelNotFoundException)', 404);
                break;
            case $this->NotFoundException($exception):
                $this->returnHTTPMessage('404 Not Found (NotFoundException)', 404);
                break;
            case $this->isValidationException($exception):
                $this->errors = $exception->errors();
                $this->returnHTTPMessage($exception->getMessage(), 422);
                break;
            case $this->AuthenticationException($exception):
                $this->returnHTTPMessage($exception->getMessage(), 401);
                break;
            case $this->isMethodNotAllowedException($exception):
                $this->returnHTTPMessage($exception->getMessage(), 405);
                break;
            case $this->isBadRequestException($exception):
                $this->returnHTTPMessage($exception->getMessage(), 400);
                break;
            default:
                $retrieve = parent::render($request, $exception);
        }

        return $retrieve;
    }

}
