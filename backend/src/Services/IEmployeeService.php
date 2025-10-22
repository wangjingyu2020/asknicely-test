<?php
namespace App\Services;

use Slim\Psr7\UploadedFile;

interface IEmployeeService
{
    public function importCsv(UploadedFile $file): void;

    public function getEmployees(): array;

    public function updateEmail(string $name, string $email): bool;

    public function getAverageSalaries(): array;
}
