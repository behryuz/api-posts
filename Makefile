deploy:
	git clean -fd
	git checkout -- .
	git checkout main
	git pull origin main
	php artisan optimize
	composer dump-autoload
	composer i
	git status

