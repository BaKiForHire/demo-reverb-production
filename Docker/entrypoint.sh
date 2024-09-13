#!/bin/bash

# Install Composer dependencies
if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

# Copy .env if it doesn't exist
if [ ! -f ".env" ]; then
    echo "Creating .env file"
    cp .env.example .env
else
    echo ".env file already exists"
fi

php artisan config:clear
php artisan key:generate
php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Start Laravel server
php artisan serve --port=$PORT --host=0.0.0.0 --env=.env

# Start Vite development server in the background
npm run dev &

# Execute the original entrypoint
exec docker-php-entrypoint "$@"
