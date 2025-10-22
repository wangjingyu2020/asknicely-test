USE asknicely_jingyu;

DROP TABLE IF EXISTS employees;

CREATE TABLE employees (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    company_name  VARCHAR(255) NOT NULL,
    employee_name VARCHAR(255) NOT NULL,
    email_address VARCHAR(255) NOT NULL,
    salary        INT NOT NULL,
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_deleted    TINYINT(1) DEFAULT 0
);
