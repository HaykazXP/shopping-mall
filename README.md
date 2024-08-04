# Laravel Project

## Requirements

- PHP 8.2 or higher
- Nginx or Apache
- MySQL

## Getting Started

Follow these steps to clone and run the project:

1. **Clone the Repository**

   Run the following command to clone the repository:

   ```bash
   git clone https://github.com/HaykazXP/shopping-mall.git
   ```

2. **Navigate to the Project Directory**

   Change to the project directory:

   ```bash
   cd shopping-mall
   ```

3. **Install Dependencies**

   Install the project dependencies using Composer:

   ```bash
   composer install
   ```

4. **Configure Environment**

   Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

   Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. **Run Database Migrations and Seeders**

   Run the database migrations:

   ```bash
   php artisan migrate
   ```

   Seed the database with the initial data:

   ```bash
   php artisan db:seed --class=CategorySeeder
   ```

6. **Start the Server**

   Start the Laravel development server:

   ```bash
   php artisan serve
   ```

   Alternatively, if you're using Nginx or Apache, configure your virtual host to point to the `public` directory of your Laravel project.

## Accessing the Application

Once the server is running, you can access the application at `http://localhost:8000` (or the port specified by your server configuration).

## Troubleshooting

- Ensure that all required services (PHP, MySQL, Nginx/Apache) are running.
- Check the `.env` file for correct database and environment settings.
- If you encounter issues, review the Laravel documentation or consult the project's issues section on GitHub.

For further assistance, refer to the [Laravel documentation](https://laravel.com/docs) or the project's support resources.
