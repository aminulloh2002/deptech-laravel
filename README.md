### INSTALLATION

- RUN composer install
- RUN npm install
- RUN npm run build
- copy .env.example to .env and set your environment variables
- RUN php artisan key:generate
- RUN php artisan migrate --seed

### USAGE
- RUN php artisan serve or use your preferred web server
- Login with the credentials:
  - Email: admin@mail.com
  - Password: password
- You can change the credentials in the database seeder file `database/seeders/AdminSeeder.php`
- finished, you can now use the application.
