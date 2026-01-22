### 📊 Expense Tracker – Laravel API + Next.js Frontend

This project is a Expense Tracker application built with Laravel REST APIs as the backend and Next.js (React.js) as the frontend.

The application allows users to manage daily expenses, generate reports, and export data securely using Laravel Sanctum authentication.

### 🚀 Tech Stack
Backend (API)

    Laravel
    PostgreSQL
    Laravel Sanctum (API Authentication)

Frontend

    Next.js
    React.js

### Axios (API communication)

### ✨ Features
🔐 Authentication

    User Registration
    Login / Logout
    Get Logged-in User (/auth/me)
    Update Profile
    Forgot Password & Reset Password

💸 Expense Management

    Add Expense
    List Expenses (Pagination supported)
    Filter Expenses by Month
    Update Expense
    Delete Expense

📊 Reports & Export

    Monthly Expense Report
    Export Expenses to CSV
    Export Expenses to PDF

### ⚙️ Environment Configuration (.env)
APP_NAME="Expense Tracker"
APP_ENV=local
APP_KEY=base64:wz0YmRxci1j4WDN/L1OplrM7nqV1EUdyAEJSD1tIKEg=
APP_DEBUG=true
APP_URL=http://localhost/project/demo_practice/React_Js/NextJS/ProjectPractice/expense-tracker-api
ASSET_URL=http://localhost/project/demo_practice/React_Js/NextJS/ProjectPractice/expense-tracker-api/public

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=expenseTrackerApi
DB_USERNAME=postgres
DB_PASSWORD=postgres

### 🛠️ Project Setup Instructions
1️⃣ Clone the Repository
git clone <repository-url>

2️⃣ Install Dependencies
composer update
npm install

3️⃣ Database Migration
php artisan migrate

4️⃣ Run the Application
php artisan serve

🔗 API Base URL
http://localhost/project/expense-tracker-api/public/api

### 📬 API Endpoints
🔐 Authentication APIs
    Method	Endpoint	Description
    POST	/auth/register	Register user
    POST	/auth/login	Login user
    POST	/auth/forgot-password	Forgot password
    POST	/auth/reset-password	Reset password
    GET	/auth/me	Get logged-in user
    PUT	/auth/update-profile	Update profile
    POST	/auth/logout	Logout user
    💸 Expense APIs (Auth Required)
    Method	Endpoint	Description
    GET	/expenses	List expenses (pagination)
    GET	/expenses?month=2025-08&per_page=1	Filter by month
    POST	/expenses	Create expense
    PUT	/expenses/{id}	Update expense
    DELETE	/expenses/{id}	Delete expense

🧪 Sample API Response (Expenses)
{
  "current_page": 1,
  "data": [
    {
      "id": 29,
      "user_id": 2,
      "amount": "1050.00",
      "category": "transport",
      "spent_at": "2025-09-05T00:00:00.000000Z",
      "note": "Electricity",
      "created_at": "2025-09-05T14:07:07.000000Z",
      "updated_at": "2025-09-05T14:07:07.000000Z"
    }
  ]
}

🔐 Authentication Note

All protected routes use Laravel Sanctum.
Pass the token in headers:

Authorization: Bearer {token}
