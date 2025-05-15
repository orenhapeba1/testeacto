FROM php:8.2-fpm

# Instala extensões do PHP e dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev npm libicu-dev docker-php-ext-configure intl docker-php-ext-install intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html