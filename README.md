# Community Management System

A comprehensive Laravel 12 application for managing community organizations with features for member management, committee coordination, meeting scheduling, and communication.

## Features

- ✅ Authentication (Registration, Login, Forgot Password, Email Verification)
- ✅ User Profile Management with Avatar Upload
- ✅ Role & Permission Management (Spatie)
- ✅ Member Management
- ✅ Committee Management
- ✅ Meeting Scheduling & Minutes Recording
- ✅ Attendance Tracking
- ✅ Task Management
- ✅ Memo System
- ✅ Notifications
- ✅ Document Management
- ✅ Reports Generation
- ✅ Livewire 3 Components
- ✅ Tailwind CSS UI

## Tech Stack

- **Laravel 12** - Web Framework
- **MySQL** - Database
- **Blade** - Templating Engine
- **Livewire 3** - Interactive Components
- **Tailwind CSS** - Styling
- **Spatie Permission** - Role & Permission Management
- **Pest** - Testing Framework

## Installation

```bash
git clone https://github.com/olamilekanpeaceco-boop/community-management-system.git
cd community-management-system
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```
