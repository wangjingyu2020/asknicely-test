<?php

namespace App\Controllers;

use App\Services\IEmployeeService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class EmployeeController
{
    private IEmployeeService $service;

    public function __construct(IEmployeeService $service)
    {
        $this->service = $service;
    }

    public function upload(Request $request, Response $response): Response
    {
        $uploadedFiles = $request->getUploadedFiles();
        if (!isset($uploadedFiles['csv'])) {
            $response->getBody()->write(json_encode(['error' => 'CSV file required.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $this->service->importCsv($uploadedFiles['csv']);
        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function list(Request $request, Response $response): Response
    {
        $data = $this->service->getEmployees();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateEmail(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();
        if (empty($params['name']) || empty($params['email'])) {
            throw new \InvalidArgumentException('Missing required fields: name and email');
        }
        $success = $this->service->updateEmail($params['name'], $params['email']);
        $response->getBody()->write(json_encode(['success' => $success]));
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function averageSalary(Request $request, Response $response): Response
    {
        $data = $this->service->getAverageSalaries();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
