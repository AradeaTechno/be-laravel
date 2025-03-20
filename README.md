## BACKEND WITH LARAVEL - JUICEBOX

This project is base structure to create a backend using laravel. This project also provides a weather service API that fetches current weather data using the WeatherAPI. It includes caching for optimal performance and a scheduled background job that updates weather data every 15 minutes.

---

## Features

- AUTH
    - Register
    - Login
    - Logout

- USER
    - Get user by ID
    - Get All User

- POSTS
    - Show all posts
    - Get post by ID
    - Add new post
    - Update Post
    - Delete Post

- Weather

--- 

## Accessibility
Except `REGISTER` and `LOGIN`, all endpoints need `BEARER TOKEN AUTHORIZATION` or will return `401`. Use Bearer token you will get from `/login` endpoint.

## Requirements
Ensure your system meets the following requirements:
- PHP >= 8.3
- Composer >= 2.x
- Laravel >= 12.x
- MySQL >= 5.8

## Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/AradeaTechno/be-laravel.git
cd be-laravel
```

## Step 2: Install Dependencies

Run the following command to install PHP dependencies:
```bash
composer install
```

If your project uses Laravel Mix, install Node.js dependencies:
```bash
npm install
```

## Step 3: Weather API key
Create **[weatherapi](https://www.weatherapi.com/)** account and get your weather API key 

## Step 4: Environment Configuration
Create the .env file from the example:
```bash
cp .env.example .env
```
Update the .env file with your environment variables:
```bash
APP_NAME=BELARAVEL
APP_ENV=local
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CACHE_DRIVER=file
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Step 5: Generate Application Key
Run the following command to generate the application key:
```bash
php artisan key:generate
```

## Step 6: Configure Database
Set up your database and run the migrations:
```bash
php artisan migrate
```

## Step 7: Configure Cache
```bash
chmod -R 775 storage/framework/cache
chmod -R 775 storage/framework/sessions
chmod -R 775 storage/logs
```

## USAGE
Start the Local Server
Run the following command to start the server:
```bash
php artisan serve
```
Visit the application in your browser at http://127.0.0.1:8000

## ALTERNATIVE TESTING
You can use postman to test all endpoinst contains in this project. I also include [Postman_collection.json] and you can import into your postman app. 

## Test Weather Service API
Use the endpoint /api/weather to fetch current weather data for a default or specified location (By default is set to Perth):
```bash
GET /api/weather?location=Perth
```

## New User Registration and Email Notification
When a user registers via the /api/register endpoint, a welcome email is sent automatically. Example:
```bash
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john.doe@example.com",
    "password": "securepassword"
}
```

## Background Jobs
## Weather Updates
Set up the Laravel scheduler to run the weather update job every 15 minutes:

1. Add the following cron job:
```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
2. Start scheduler:
```bash
php artisan schedule:work
```

## Email Queue
Emails are sent asynchronously via Laravel queues. Ensure the queue worker is running:
```bash
php artisan queue:work
```

### Testing
Run Unit and Feature Tests
Ensure all tests pass:

To run all tests at once;
```bash
php artisan --filter=ApiEndpointsTest
```

To run test by name `e.g`:
```bash
php artisan test --filter=ApiEndpointsTest::test_can_get_all_post
```

## ADDITIONAL SETTING
In your `phpunit.xml` file change the following setting to make test run well:
```bash
<env name="DB_CONNECTION" value="mysql"/>
<env name="DB_DATABASE" value="YourDatabaseName"/>
```