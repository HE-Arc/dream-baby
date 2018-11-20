
all: clean migrate serve

clean:
	rm -rf ./storage/app/*profilImage.*

migrate:
	php artisan migrate:refresh --seed || (composer dump-autoload; php artisan migrate:refresh --seed;)

serve:
	php artisan serve;