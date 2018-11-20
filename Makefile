
all: migrate serve

migrate:
	composer dump-autoload
	php artisan migrate:refresh --seed

serve:
	php artisan serve