
all: clean install update-npm migrate compile-scss serve

install:
	composer install

clean:
	rm -rf ./storage/app/*profilImage.*

migrate:
	php artisan migrate:refresh --seed || (composer dump-autoload; php artisan migrate:refresh --seed;)

compile-scss:
	npm run dev

serve:
	php artisan serve;

update-npm:
	npm install
