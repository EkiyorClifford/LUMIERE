don't foget to add expires_at to sessions table
Then run a scheduled job (php artisan schedule:run) to purge abandoned guest carts after 30 days. Without this, your carts table bloats indefinitely.

