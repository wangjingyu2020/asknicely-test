<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\Container;
use Dotenv\Dotenv;
use App\Middleware\CorsMiddleware;
use App\Handlers\AppErrorHandler;

require __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->add(new CorsMiddleware());
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(new AppErrorHandler());

(require __DIR__ . '/../Dependencies.php')($container);

return $app;
