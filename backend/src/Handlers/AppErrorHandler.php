<?php
namespace App\Handlers;

use Slim\Exception\HttpException;
use Slim\Interfaces\ErrorHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class AppErrorHandler implements ErrorHandlerInterface
{
    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        error_log('[ERROR] ' . $exception->getMessage());

        $responseFactory = new \Slim\Psr7\Factory\ResponseFactory();
        $response = $responseFactory->createResponse();

        $statusCode = $exception instanceof HttpException
            ? $exception->getCode()
            : 500;

        $payload = [
            'error' => 'Internal Server Error',
            'message' => $displayErrorDetails ? $exception->getMessage() : 'Something went wrong',
        ];

        $response->getBody()->write(json_encode($payload));
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }
}
