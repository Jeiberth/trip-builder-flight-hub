# ✈️ Trip Builder - Flight Booking Application

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-red)](https://laravel.com/)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-green)](https://vuejs.org/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A modern, full-stack web application for searching and booking flights. Built with Laravel (PHP) for the backend API and Vue 3 for the frontend single-page application.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technologies](#technologies)
- [Architecture](#architecture)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
  - [Windows](#windows-installation)
  - [Linux](#linux-installation)
  - [macOS](#macos-installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [API Documentation](#api-documentation)
- [Testing](#testing)
- [Deployment](#deployment)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## 🎯 Overview

Trip Builder is a comprehensive flight booking system that allows users to:
- Search for one-way and round-trip flights
- Filter flights by airline, date, and airports
- Book flights with real-time availability
- View their booking history
- Manage trip details

The application follows modern web development practices with a RESTful API backend and a reactive frontend SPA.

---

## ✨ Features

### Frontend Features
- 🔍 Advanced flight search with multiple filters
- 📅 Date-based flight availability
- ✈️ One-way and round-trip booking support
- 💳 Instant booking confirmation
- 📱 Responsive design for all devices
- 🎨 Modern UI with Bootstrap 5
- 🔔 Real-time notifications with SweetAlert2

### Backend Features
- 🚀 RESTful API architecture
- 🔐 Robust data validation
- 🗄️ Relational database design
- 🧪 Comprehensive test coverage
- 📊 Efficient query optimization with Eloquent ORM
- 🔄 Transaction management for bookings
- ⏰ Timezone-aware flight scheduling

---

## 🛠 Technologies

### Backend
- **PHP** 8.1+
- **Laravel** 10.x
- **MySQL** 8.0+ / PostgreSQL 13+
- **Composer** 2.x
- **PHPUnit** for testing

### Frontend
- **Vue.js** 3.x
- **Axios** for HTTP requests
- **Bootstrap** 5.3
- **SweetAlert2** for notifications
- Vanilla JavaScript (no build tools required)

### Development Tools
- Git for version control
- Laravel Artisan CLI
- Laravel Tinker for debugging
- Browser DevTools

---

## 🏗 Architecture

### System Architecture

```
┌─────────────────────────────────────────────────────────┐
│                     Frontend (Vue 3)                     │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐ │
│  │ Search Flights│  │  View Trips  │  │ Book Flights │ │
│  └──────────────┘  └──────────────┘  └──────────────┘ │
└─────────────────────────┬───────────────────────────────┘
                          │ Axios (HTTP/JSON)
                          ▼
┌─────────────────────────────────────────────────────────┐
│                  Backend API (Laravel)                   │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐ │
│  │ Controllers  │  │   Models     │  │  Validation  │ │
│  └──────────────┘  └──────────────┘  └──────────────┘ │
└─────────────────────────┬───────────────────────────────┘
                          │ Eloquent ORM
                          ▼
┌─────────────────────────────────────────────────────────┐
│              Database (MySQL/PostgreSQL)                 │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐ │
│  │   Airlines   │  │   Airports   │  │    Flights   │ │
│  │    Trips     │  │ Trip Flights │  │              │ │
│  └──────────────┘  └──────────────┘  └──────────────┘ │
└─────────────────────────────────────────────────────────┘
```

### Database Schema

```
airlines (code, name)
    ↓
flights (id, airline_code*, departure_airport*, arrival_airport*, ...)
    ↓
trip_flights (id, trip_id*, flight_id*, position, price)
    ↓
trips (id, type, created_at, total_price)

airports (code, city_code, name, city, timezone, ...)
```

### API Architecture

The application follows RESTful principles:

- **GET** `/api/airports` - Retrieve all airports
- **GET** `/api/airlines` - Retrieve all airlines
- **GET** `/api/flights` - Search flights with filters
- **GET** `/api/trips` - Retrieve booked trips
- **POST** `/api/book/trip` - Create a new booking

---

## 📦 Prerequisites

### Required Software

#### All Platforms
- **Git** (latest version)
- **Composer** 2.x or higher
- **Node.js** 16.x+ and npm (optional, for frontend build tools)
- A modern web browser (Chrome, Firefox, Safari, or Edge)

#### Windows
- **XAMPP** / **Laragon** / **Herd** (includes PHP, MySQL, Apache)
- **PHP** 8.1+ (if not using XAMPP)
- **MySQL** 8.0+ or **PostgreSQL** 13+

#### Linux
```bash
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-mbstring php8.1-xml php8.1-mysql php8.1-curl
sudo apt install mysql-server
sudo apt install composer
```

#### macOS
```bash
# Install Homebrew if not already installed
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Install PHP and MySQL
brew install php@8.1
brew install mysql
brew install composer
```

### System Requirements

- **RAM**: Minimum 4GB (8GB recommended)
- **Storage**: At least 500MB free space
- **OS**: Windows 10+, Ubuntu 20.04+, macOS 11+

---

## 🚀 Installation

### Clone the Repository

```bash
git clone https://github.com/Jeiberth/trip-builder-flight-hub.git
cd trip-builder
```

---

### Windows Installation

#### 1. Install XAMPP or Laragon

**Option A: XAMPP**
- Download from [https://www.apachefriends.org/](https://www.apachefriends.org/)
- Install with PHP 8.1+ and MySQL
- Start Apache and MySQL from XAMPP Control Panel

**Option B: Laragon**
- Download from [https://laragon.org/](https://laragon.org/)
- Install Full version (includes PHP, MySQL, Composer)
- Start all services

#### 2. Install Composer

If not included with XAMPP/Laragon:
- Download from [https://getcomposer.org/download/](https://getcomposer.org/download/)
- Run installer
- Verify: `composer --version`

#### 3. Install Backend Dependencies

```cmd
cd backend
composer install
```

#### 4. Set Up Environment

```cmd
copy .env.example .env
php artisan key:generate
```

#### 5. Configure Database

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trip_builder
DB_USERNAME=root
DB_PASSWORD=
```

Create database in MySQL:
```sql
CREATE DATABASE trip_builder;
```

#### 6. Run Migrations

```cmd
php artisan migrate
php artisan db:seed
```

#### 7. Start Development Server

```cmd
php artisan serve
```

Backend API will be available at: `http://localhost:8000`

---

### Linux Installation

#### 1. Install Dependencies

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-mbstring php8.1-xml php8.1-mysql \
                 php8.1-curl php8.1-zip php8.1-gd php8.1-bcmath
sudo apt install mysql-server
sudo apt install composer
```

**Fedora/RHEL:**
```bash
sudo dnf install php php-cli php-mbstring php-xml php-mysqlnd php-curl php-zip
sudo dnf install mysql-server
sudo dnf install composer
```

#### 2. Secure MySQL

```bash
sudo mysql_secure_installation
```

#### 3. Start MySQL Service

```bash
sudo systemctl start mysql
sudo systemctl enable mysql
```

#### 4. Clone and Setup Project

```bash
git clone https://github.com/Jeiberth/trip-builder-flight-hub.git
cd trip-builder/backend
composer install
cp .env.example .env
php artisan key:generate
```

#### 5. Configure Database

```bash
# Login to MySQL
sudo mysql -u root -p

# Create database
CREATE DATABASE trip_builder;
CREATE USER 'trip_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON trip_builder.* TO 'trip_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trip_builder
DB_USERNAME=trip_user
DB_PASSWORD=secure_password
```

#### 6. Run Migrations

```bash
php artisan migrate
php artisan db:seed
```

#### 7. Start Server

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

### macOS Installation

#### 1. Install Homebrew

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

#### 2. Install PHP and MySQL

```bash
brew install php@8.1
brew install mysql
brew install composer

# Add PHP to PATH (add to ~/.zshrc or ~/.bash_profile)
echo 'export PATH="/opt/homebrew/opt/php@8.1/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc
```

#### 3. Start MySQL

```bash
brew services start mysql

# Secure MySQL installation
mysql_secure_installation
```

#### 4. Clone and Setup Project

```bash
git clone https://github.com/Jeiberth/trip-builder-flight-hub.git
cd trip-builder/backend
composer install
cp .env.example .env
php artisan key:generate
```

#### 5. Configure Database

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE trip_builder;
EXIT;
```

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trip_builder
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

#### 6. Run Migrations

```bash
php artisan migrate
php artisan db:seed
```

#### 7. Start Server

```bash
php artisan serve
```

---

## ⚙️ Configuration

### Environment Variables

Create a `.env` file in the backend directory with the following variables:

```env
# Application
APP_NAME="Trip Builder"
APP_ENV=local
APP_KEY=base64:GENERATED_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trip_builder
DB_USERNAME=root
DB_PASSWORD=

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=debug

# Other services (optional)
MAIL_MAILER=smtp
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

### Frontend Configuration

Edit `trip-builder\src\services\api.js` line 239:

```javascript
const API_URL = 'http://localhost:8000/api';
```

Update this to match your backend URL in production.

### CORS Configuration

If you encounter CORS errors, update `config/cors.php`:

```php
'paths' => ['api/*'],
'allowed_origins' => ['*'], // Change to specific domains in production
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

---

## 🗄 Database Setup

### Migrations

The project includes migrations for all database tables:

```bash
# Run all migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset and re-run migrations
php artisan migrate:fresh

# Run migrations with seeding
php artisan migrate:fresh --seed
```

### Seeders

Sample data is provided for testing:

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=DatabaseSeeder
```

**Seeded Data:**
- 2 Airlines (Air Canada, WestJet)
- 3 Airports (YUL, YVR, YYZ)
- 42 Flights (6 flights per day for 7 days)

### Manual Database Creation

**MySQL:**
```sql
CREATE DATABASE trip_builder CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**PostgreSQL:**
```sql
CREATE DATABASE trip_builder WITH ENCODING 'UTF8';
```

---

## 🎮 Running the Application

### Backend (Laravel API)

#### Development Server

**All Platforms:**
```bash
cd backend
php artisan serve
```

Access API at: `http://localhost:8000`

#### Custom Host/Port

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

#### Queue Workers (if using queues)

```bash
php artisan queue:work
```

### Frontend (Vue 3 SPA)

#### Option 1: Local Web Server (Recommended)

**Node.js (http-server):**
```bash
cd trip-builder
npm install
npm run dev
```

Access frontend at: `http://localhost:5173`

### Full Stack Development

**Terminal 1 (Backend):**
```bash
php artisan serve
```

**Terminal 2 (Frontend):**
```bash
cd trip-builder
npm run dev
```

---

## 📚 API Documentation

### Base URL

```
http://localhost:8000/api
```

### Endpoints

#### 1. Get All Airports

```http
GET /airports
```

**Response:**
```json
[
  {
    "code": "YUL",
    "city_code": "YMQ",
    "name": "Pierre Elliott Trudeau International",
    "city": "Montreal",
    "country_code": "CA",
    "region_code": "QC",
    "latitude": "45.457714",
    "longitude": "-73.749908",
    "timezone": "America/Montreal",
    "utc_offset": -5
  }
]
```

#### 2. Get All Airlines

```http
GET /airlines
```

**Response:**
```json
[
  {
    "code": "AC",
    "name": "Air Canada"
  }
]
```

#### 3. Search Flights

```http
GET /flights?departure_airport={code}&arrival_airport={code}&departure_at={date}&return_at={date}&airline={code}
```

**Query Parameters:**
- `departure_airport` (required): IATA airport code
- `arrival_airport` (required): IATA airport code
- `departure_at` (required): Date in YYYY-MM-DD format
- `return_at` (optional): Date in YYYY-MM-DD format (for round trips)
- `airline` (optional): IATA airline code filter

**Example:**
```http
GET /flights?departure_airport=YUL&arrival_airport=YVR&departure_at=2024-12-25
```

**Response:**
```json
[
  {
    "id": 1,
    "airline_code": "AC",
    "number": "301",
    "departure_airport": "YUL",
    "arrival_airport": "YVR",
    "departure_at": "2024-12-25T07:35:00.000000Z",
    "arrival_at": "2024-12-25T10:05:00.000000Z",
    "price": "273.23",
    "airline": {
      "code": "AC",
      "name": "Air Canada"
    },
    "departureAirport": { ... },
    "arrivalAirport": { ... }
  }
]
```

#### 4. Get All Trips

```http
GET /trips
```

**Response:**
```json
[
  {
    "id": 1,
    "type": "ROUND_TRIP",
    "created_at": "2024-11-14T12:00:00.000000Z",
    "total_price": "493.86",
    "trip_flights": [
      {
        "id": 1,
        "trip_id": 1,
        "flight_id": 1,
        "position": 1,
        "price": "273.23",
        "flight": { ... }
      },
      {
        "id": 2,
        "trip_id": 1,
        "flight_id": 2,
        "position": 2,
        "price": "220.63",
        "flight": { ... }
      }
    ]
  }
]
```

#### 5. Book a Trip

```http
POST /book/trip
Content-Type: application/json

{
  "flight_id": 1,
  "return_flight_id": 2  // Optional, for round trips
}
```

**Response (Success):**
```json
{
  "success": true,
  "trip_id": 1
}
```

**Response (Error):**
```json
{
  "success": false,
  "message": "Failed to book trip: Flight not found"
}
```

### HTTP Status Codes

- `200 OK` - Request successful
- `201 Created` - Resource created successfully
- `422 Unprocessable Entity` - Validation error
- `500 Internal Server Error` - Server error

---

## 🧪 Testing

### Running Tests

**All Tests:**
```bash
php artisan test
```

**Specific Test Suite:**
```bash
php artisan test --testsuite=Feature
```

**Specific Test File:**
```bash
php artisan test tests/Feature/FlightApiTest.php
```

**With Coverage:**
```bash
php artisan test --coverage
```

### Test Structure

```
tests/
├── Feature/
│   ├── AirlineApiTest.php
│   ├── AirportApiTest.php
│   ├── FlightApiTest.php
│   ├── TripApiTest.php
│   └── BookTripApiTest.php
└── Unit/
```

### Writing New Tests

Create a new test:
```bash
php artisan make:test FlightSearchTest
```

Example test:
```php
public function test_search_flights_with_filters(): void
{
    $response = $this->getJson('/api/flights?departure_airport=YUL&arrival_airport=YVR&departure_at=2024-12-25');
    
    $response->assertStatus(200)
             ->assertJsonStructure([
                 '*' => ['id', 'airline_code', 'departure_at']
             ]);
}
```

---

## 📖 Additional Resources

### Laravel Documentation
- [Official Documentation](https://laravel.com/docs)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [API Resources](https://laravel.com/docs/eloquent-resources)

### Vue.js Documentation
- [Vue 3 Guide](https://vuejs.org/guide/)
- [Composition API](https://vuejs.org/api/composition-api-setup.html)

### Development Tools
- [Postman](https://www.postman.com/) - API testing
- [TablePlus](https://tableplus.com/) - Database management
- [VS Code](https://code.visualstudio.com/) - Code editor

---

## 🤝 Contributing

### How to Contribute

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push to branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

### Coding Standards

**PHP (Backend):**
- Follow PSR-12 coding standard
- Use meaningful variable names
- Write PHPDoc comments
- Run tests before committing

**JavaScript (Frontend):**
- Use ES6+ syntax
- Follow Vue.js style guide
- Use consistent indentation (2 spaces)
- Add comments for complex logic

### Running Code Style Checks

```bash
# PHP CS Fixer
composer require --dev friendsofphp/php-cs-fixer
./vendor/bin/php-cs-fixer fix

# PHPStan (Static Analysis)
composer require --dev phpstan/phpstan
./vendor/bin/phpstan analyse
```

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2024 Trip Builder

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
```

---

## 👥 Authors

- **Jeiberth** - *Initial work* - [GitHub](https://github.com/jeiberth)

---

## 🙏 Acknowledgments

- Laravel Framework team
- Vue.js team
- Bootstrap team
- SweetAlert2 developers
- All contributors and testers

---

## 📞 Support

### Reporting Bugs

When reporting bugs, please include:
1. Operating system and version
2. PHP version (`php -v`)
3. Laravel version (`php artisan --version`)
4. Steps to reproduce
5. Expected vs actual behavior
6. Error messages and logs

---

## 🗺 Roadmap

### Planned Features

- [ ] User authentication and authorization
- [ ] Payment gateway integration
- [ ] Multi-currency support
- [ ] Email notifications
- [ ] Advanced search filters (price range, duration)
- [ ] Flight comparison feature
- [ ] Mobile app (React Native)
- [ ] Admin dashboard
- [ ] Real-time flight status updates
- [ ] Multi-language support

### Version History

**v1.0.0** (Current)
- Initial release
- Basic flight search and booking
- One-way and round-trip support
- Trip management

---

## 📊 Performance

### Optimization Tips

**Backend:**
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

**Database:**
```php
// Use eager loading
$trips = Trip::with('tripFlights.flight')->get();

// Add database indexes
Schema::table('flights', function (Blueprint $table) {
    $table->index(['departure_airport', 'arrival_airport', 'departure_at']);
});
```

**Frontend:**
- Minimize API calls
- Implement caching strategies
- Use lazy loading for images
- Enable browser caching

---

## 🔒 Security

### Best Practices

1. **Never commit `.env` files**
2. **Use strong database passwords**
3. **Keep dependencies updated**
   ```bash
   composer update
   ```
4. **Enable HTTPS in production**
5. **Sanitize user inputs** (Laravel handles this)
6. **Use prepared statements** (Eloquent does this)
7. **Implement rate limiting**
   ```php
   // In RouteServiceProvider
   RateLimiter::for('api', function (Request $request) {
       return Limit::perMinute(60);
   });