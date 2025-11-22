# Laravel E-Commerce API

This is a Laravel API project for a simple e-commerce system, including:

- User authentication (register/login)
- Products CRUD
- Cart & Orders
- Stock management
- API standardized responses using `ApiResponse` helper
- Resources for structured JSON responses

- Backend Deliverables (Laravel Project)
   Project Structure

 Organized Laravel folders:

 app/Models → كل الموديلات.

 app/Http/Controllers → كل الكنترولرز.

 app/Http/Requests → للتحقق من البيانات (Validation).

 routes/api.php → كل الـ API routes.

 database/migrations → كل الـ migrations.

 database/seeders → بيانات تجريبية (اختياري).

---

##  Setup

### 1. Clone repository
```bash
git clone https://github.com/yourusername/laravel-ecommerce-api.git
cd laravel-ecommerce-api

2. Install dependencies
composer install

3. Create .env file
cp .env.example .env

Edit .env file to set your database credentials and JWT secret:
APP_NAME=Laravel
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=your_jwt_secret_here

4. Generate application key
php artisan key:generate

5. Run migrations and seeders
php artisan migrate --seed

6. Generate JWT secret
php artisan jwt:secret

7. Run server
php artisan serve
Server will run at: http://127.0.0.1:8000

 Authentication
Register

POST /api/auth/register

Request:
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
Response:
{
  "status": true,
  "message": "User created successfully",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-11-22T12:00:00.000000Z",
    "updated_at": "2025-11-22T12:00:00.000000Z"
  },
  "token": "JWT_TOKEN_HERE"
}


Login

POST /api/auth/login

Request:
{
  "email": "john@example.com",
  "password": "password"
}
Response:
{
  "status": true,
  "message": "Login successful",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "JWT_TOKEN_HERE"
}

 2️⃣ API Endpoints   (Authenticated)
 
 | Method | Endpoint       | Description                  |
| ------ | -------------- | ---------------------------- |
| GET    | /dashboard     | Total products, total orders |
| GET    | /products      | List products (paginated)    |
| POST   | /products      | Create product               |
| PUT    | /products/{id} | Update product               |
| DELETE | /products/{id} | Delete product               |
| GET    | /orders        | List orders                  |
| GET    | /orders/{id}   | Show order details           |
| GET    | /auth/me       | Get current user profile     |
| PUT    | /auth/me       | Update profile & password    |

Notes
All API responses are standardized using ApiResponse helper.

Stock is automatically updated when orders are created.

Use Authorization: Bearer JWT_TOKEN for protected routes.

Products, Orders, and Users have Resource classes for consistent JSON output.

Simple DB diagram
 Database

ERD
users → id, name, email, password, role
products → id, name, price, stock, status
cart_items -> id , user_id , product_id ,quantity 
orders → id, order_number, total, address, phone
order_items → order_id, product_id, quantity, subtotal
 timestamps (created_at, updated_at)

Seeder: لو تحب تبعت بيانات تجريبية للـ products و orders.

