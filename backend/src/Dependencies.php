<?php

use Psr\Container\ContainerInterface;
use App\Models\Employee;
use App\Services\IEmployeeService;
use App\Services\Impl\EmployeeServiceImpl;
use App\Controllers\EmployeeController;
use Dotenv\Dotenv;

return function (ContainerInterface $container) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $container->set('db', function () {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $charset = $_ENV['DB_CHARSET'];

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    });

    $container->set(Employee::class, fn($c) => new Employee($c->get('db')));

    $container->set(IEmployeeService::class, fn($c) => new EmployeeServiceImpl($c->get(Employee::class))
    );

    $container->set(EmployeeController::class, fn($c) => new EmployeeController($c->get(IEmployeeService::class))

    );

};
