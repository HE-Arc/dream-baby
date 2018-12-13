
all: clean migrate compile-scss update-npm serve

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