# Test task

### How to run

1. Install dependencies:
   ```
   composer install
   ```
2. Generate a key:
   ```
   php artisan key:generate
   ```
3. Run migrations with seeding:
   ```
   php artisan migrate --seed
   ```
4. Test:
   ```
   php artisan test
   ```
5. Start the development server:
   ```
   php artisan serve
   ```

## Postman Configuration

1. Import `postman_collection.json` file to your Postman app.
2. Set the base URL to `http://localhost:8000`

## TODO

- Add more tests
- Add caching
- Add throttling