<?php
use Slim\App;
use App\Controllers\EmployeeController;

return function (App $app) {
    $container = $app->getContainer();
    $controller = $container->get(EmployeeController::class);

    $app->get('/api/employees', [$controller, 'list']);
    $app->post('/api/upload', [$controller, 'upload']);
    $app->put('/api/update-email', [$controller, 'updateEmail']);
    $app->get('/api/average-salary', [$controller, 'averageSalary']);
};
