# Employee Management System (Laravel 12)

A simple employee management system built with Laravel 12 and MySQL that allows for CRUD operations on departments and employees, including dashboard statistics, custom login with remember me, and more.

---

## 🔧 Installation Instructions

1. **Clone the repository or extract the zip**
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Run `php artisan key:generate`
5. Configure `.env` with your local DB settings:
    ```env
    DB_DATABASE=employee_management
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```
6. Import the database:
   - Open **phpMyAdmin**
   - Create a new DB `employee_management`
   - Import `employee_management.sql` from the project root

7. Create the symbolic link for storage:
   ```bash
   php artisan storage:link
   ```
8. Run the project:
   ```bash
   php artisan serve
   ```

---

## 🔐 Login Credentials

- **Email**: test@example.com
- **Password**: password

---

## 🧩 Features Implemented

### 🔑 Authentication
- Custom login without auth scaffolding
- Remember me functionality

### 📁 Department Management
- Add, edit, delete departments

### 👥 Employee Management
- Add, edit, delete employees
- Upload and display profile photo
- Toggle active/inactive status
- Frontend + backend validation
- Pagination

### 📊 Dashboard
- Department-wise highest salary
- Salary range count
- Youngest employee per department (with age in years and months)

---

## 📦 Folder Structure
```
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── DepartmentController.php
│   │   ├── EmployeeController.php
│   │   └── DashboardController.php
├── resources/views/
│   ├── layout.blade.php
│   ├── auth/login.blade.php
│   ├── dashboard.blade.php
│   ├── departments/
│   └── employees/
├── public/
│   └── storage/ (linked folder for images)
├── routes/web.php
└── database/employee_management.sql
```

---

## ✅ Final Checklist
- [x] Laravel project runs without errors
- [x] Database imported successfully
- [x] All required features implemented
- [x] Code tested and validated
- [x] README added
- [x] ZIP ready for submission

---

> Built with ❤️ using Laravel 12

