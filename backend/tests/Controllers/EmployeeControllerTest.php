<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class EmployeeControllerTest extends TestCase
{
    protected \Slim\App $app;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../bootstrap.php';
        $this->app = $GLOBALS['app'];
    }

    public function testListEmployees(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/api/employees');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string)$response->getBody();
        $data = json_decode($body, true);

        $this->assertIsArray($data);
        if (!empty($data)) {
            $this->assertArrayHasKey('employee_name', $data[0]);
        }
    }

    public function testUploadWithoutFile(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('POST', '/api/upload');
        $response = $this->app->handle($request);

        $this->assertEquals(400, $response->getStatusCode());

        $body = (string)$response->getBody();
        $data = json_decode($body, true);

        $this->assertIsArray($data);
        $this->assertEquals('CSV file required.', $data['error']);
    }

    public function testAverageSalary(): void
    {
        $request = (new ServerRequestFactory())->createServerRequest('GET', '/api/average-salary');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $body = (string)$response->getBody();
        $data = json_decode($body, true);
    }


}
