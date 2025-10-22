<?php
namespace App\Services\Impl;

use App\Models\Employee;
use Slim\Psr7\UploadedFile;
use App\Services\IEmployeeService;

class EmployeeServiceImpl implements IEmployeeService
{
    private Employee $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function importCsv(UploadedFile $file): void
    {
        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('File upload error.');
        }

        $stream = $file->getStream();
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, $stream->getContents());
        rewind($handle);

        fgetcsv($handle);
        while (($row = fgetcsv($handle)) !== false) {
            $this->model->insert([
                'company_name' => $row[0],
                'employee_name' => $row[1],
                'email_address' => $row[2],
                'salary' => (int)$row[3],
            ]);
        }

        fclose($handle);
    }

    public function getEmployees(): array
    {
        return $this->model->getAll();
    }

    public function updateEmail(string $name, string $email): bool
    {
        return $this->model->updateEmail($name, $email);
    }

    public function getAverageSalaries(): array
    {
        return $this->model->getAverageSalaries();
    }
}
