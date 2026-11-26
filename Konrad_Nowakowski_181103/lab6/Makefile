server-run:
	sudo systemctl start httpd php-fpm mariadb
	@echo "Środowisko uruchomione: http://localhost/phpmyadmin"
	php --server localhost:8000 --docroot .

server-stop:
	sudo systemctl stop httpd php-fpm mariadb
	@echo "Środowisko zatrzymane."

server-status:
	@systemctl is-active httpd php-fpm mariadb
