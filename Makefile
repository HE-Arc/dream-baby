
all: migrate serve

migrate:
	php artisan migrate:refresh --seed

serve:
	php artisan serve