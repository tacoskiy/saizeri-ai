FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl && \
    docker-php-ext-install pdo pdo_mysql zip && \
    rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /container-backend

COPY . .

RUN composer install --optimize-autoloader --no-scripts

RUN chown -R www-data:www-data /container-backend \
    && chmod -R 755 /container-backend

EXPOSE 8000

CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=8000" ]