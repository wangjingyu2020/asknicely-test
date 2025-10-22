#  AskNicely Test

## Project Overview

This project was built as part of the AskNicely engineering test to demonstrate full-stack development capabilities using PHP and MySQL. It provides a web-based interface for uploading and managing employee data from a CSV file. The frontend is built with Vue 3, and the backend is powered by PHP (Slim framework), all containerized using Docker.

---

##  Tech Stack

| Layer            | Technology           |
|------------------|----------------------|
| Frontend         | Vue 3 + Vite         |
| Backend          | PHP (Slim Framework) |
| Database         | MySQL                |
| Containerization | Docker               |
| Testing          | PHPUnit              |

---

##  Features Completed

I have implemented the following core features:

-  Upload a CSV file via the web interface  
-  Parse and import employee data into a MySQL database  
-  Display a list of employees grouped by company  
-  Edit an employee’s email address inline  
-  Show the average salary for each company  
-  Search employees by name, email, company name, or salary  

###  Bonus Features

-  Dockerized deployment with non-standard ports to avoid conflicts  
-  Backend unit tests using PHPUnit  

---

##  How to Run the Project (Docker Setup)

This project is fully containerized using Docker and Docker Compose. All services run on non-standard ports to avoid conflicts with existing services on the host machine.

###  Prerequisites

- Docker installed on your system  

- Docker Compose installed  

###  Step-by-Step Instructions

1. Clone the repository and start the project using Docker

```bash
git clone https://github.com/wangjingyu2020/asknicely-test.git

cd asknicely-test

docker-compose up --build
```

2. Port Configuration Overview

This project uses non-standard ports to avoid conflicts with other services that may be running on the host machine. Below is a breakdown of the port mappings defined in docker-compose.yml:

| Service   | Container Port | Host Port | Description                                      |
|-----------|----------------|-----------|--------------------------------------------------|
| MySQL     | 3306           | 3306      | Standard MySQL port exposed for local access     |
| Backend   | 80             | 8080      | PHP Slim backend API exposed on host port 8080   |
| Frontend  | 80             | 3000      | Vue 3 frontend exposed on host port 3000         |


Changing Ports
If you need to change any of these ports (e.g., due to conflicts with other services), simply update the ports section in docker-compose.yml and restart the containers:

```bash
docker-compose down

docker-compose up --build
```


## How to Run the Project Locally (Without Docker)

If you prefer to run the project without Docker, follow these steps to set up the backend and frontend manually.

### Prerequisites

PHP 8.1+ with PDO extension enabled

Composer (for PHP dependencies)

Node.js 20.19+ and npm (for frontend build)

MySQL 8.0+

###  Step-by-Step Instructions

1. Backend Setup
Create a MySQL database

Create a database named asknicely_jingyu and import the schema from backend/mysql/init.sql.

```bash
cd backend

composer install

php -S localhost:8080 -t public
```

2. Frontend Setup

Install frontend dependencies

```bash
cd frontend

npm install
```

3. Update the proxy configuration in vite.config.ts to match your local backend address and port.

   ```ts
     proxy: {
       '/api': {
         target: 'http://localhost:8080',
         changeOrigin: true,
       },
    },
    ```
    
4. Then start the frontend development server.
```bash
npm run dev
```


## Future Improvements (If Given Unlimited Time)

Add support for unique user identifiers to prevent duplicate imports and enable precise updates. Currently, email updates rely on matching employee names, which may lead to ambiguity. Introducing user IDs would allow for reliable record matching, deduplication, and safer multi-import workflows.

Introduce a permission system to restrict access and editing rights. Currently, a single admin can modify any employee’s information across all companies. In a real-world scenario, role-based access control (RBAC) should be implemented to ensure that users can only manage employees within their own organization or scope.

Add user authentication and login system to support secure access and personalized permissions. With role-based access control planned, a robust authentication layer is essential to identify users, manage sessions, and enforce access boundaries. This would include login, logout, token-based authentication (e.g., JWT), and potentially OAuth integration for enterprise scenarios.

Refine exception handling by categorizing error types more granularly across frontend and backend. Currently, both layers use global error handlers, but lack detailed classification (e.g., validation errors, authentication failures, business logic violations). Introducing structured error codes and typed responses would improve debugging, user feedback, and automated testing.

Implement server-side file storage to persist uploaded CSV files for auditing, reprocessing, or historical tracking.

API Documentation Generate OpenAPI (Swagger) docs for backend endpoints to improve developer onboarding.

Full Test Coverage Expand PHPUnit coverage to include integration tests, edge cases, and automated validation of error handling.

Add seed data for consistent unit testing and easier backend validation.

Add frontend mock support to simulate backend responses during development and improve UI testing without relying on live data.

Add frontend animations and loading indicators to enhance user experience and provide visual feedback during interactions.