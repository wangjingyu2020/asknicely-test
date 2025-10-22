<?php

namespace App\Models;

use PDO;

class Employee
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function insert(array $data): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO employees (company_name, employee_name, email_address, salary)
            VALUES (:company, :name, :email, :salary)
        ");
        $stmt->execute([
            'company' => $data['company_name'],
            'name' => $data['employee_name'],
            'email' => $data['email_address'],
            'salary' => $data['salary'],
        ]);
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM employees WHERE is_deleted = FALSE");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateEmail(string $name, string $email): bool
    {
        $stmt = $this->db->prepare("
            UPDATE employees
            SET email_address = :email, updated_at = NOW()
            WHERE employee_name = :name
    ");
        return $stmt->execute([
            'email' => $email,
            'name' => $name
        ]);
    }


    public function getAverageSalaries(): array
    {
        $stmt = $this->db->query("
            SELECT company_name, AVG(salary) AS avg_salary
            FROM employees
            WHERE is_deleted = FALSE
            GROUP BY company_name
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
