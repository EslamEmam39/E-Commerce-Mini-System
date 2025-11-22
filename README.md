# Laravel E-Commerce API

This is a Laravel API project for a simple e-commerce system, including:

- User authentication (register/login)
- Products CRUD
- Cart & Orders
- Stock management
- API standardized responses using `ApiResponse` helper
- Resources for structured JSON responses

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

 Products
List Products

GET /api/products  (Authenticated)

Response: (paginated)
{
  "status": true,
  "message": "success",
  "data": {
    "products": [
      {
        "id": 1,
        "name": "Laptop",
        "description": "High performance laptop",
        "price": "2500.00",
        "stock": 10,
        "status": "in_stock",
        "created_at": "2025-11-22T12:00:00.000000Z",
        "updated_at": "2025-11-22T12:00:00.000000Z"
      }
    ],
    "meta": {
      "current_page": 1,
      "last_page": 10,
      "per_page": 10,
      "total": 100
    },
    "links": {
      "next_page_url": "...",
      "prev_page_url": null
    }
  }
}

Create Product

POST /api/products (Authenticated)

Request:
{
  "name": "Laptop",
  "description": "High performance laptop",
  "price": 2500,
  "stock": 10
}

Response :
{
  "status": true,
  "message": "Product created successfully",
  "data": {
    "id": 1,
    "name": "Laptop",
    "description": "High performance laptop",
    "price": "2500.00",
    "stock": 10,
    "status": "in_stock"
  }
}

Cart & Orders
Create Order

POST /api/orders (Authenticated)

Request:
{
  "address": "123 Main Street, City",
  "phone": "+1234567890"
}
Response:
{
  "status": true,
  "message": "Order created successfully",
  "data": {
    "order_number": 5,
    "total": 320.5,
    "items": [
      {
        "name": "Product 1",
        "quantity": 2,
        "price": 100.25,
        "subtotal": 200.5
      },
      {
        "name": "Product 2",
        "quantity": 1,
        "price": 120,
        "subtotal": 120
      }
    ]
  }
}
Notes
All API responses are standardized using ApiResponse helper.

Stock is automatically updated when orders are created.

Use Authorization: Bearer JWT_TOKEN for protected routes.

Products, Orders, and Users have Resource classes for consistent JSON output.

Simple DB diagram

Users
-----
id (PK)
name
email
password
created_at
updated_at

Addresses
---------
id (PK)
user_id (FK -> Users.id)
address
phone
created_at
updated_at

Products
--------
id (PK)
name
description
price
stock
status
created_at
updated_at

CartItems
---------
id (PK)
user_id (FK -> Users.id)
product_id (FK -> Products.id)
quantity
created_at
updated_at

Orders
------
id (PK)
user_id (FK -> Users.id)
address_id (FK -> Addresses.id)
total
created_at
updated_at

OrderItems
----------
id (PK)
order_id (FK -> Orders.id)
product_id (FK -> Products.id)
quantity
price
subtotal
created_at
updated_at


