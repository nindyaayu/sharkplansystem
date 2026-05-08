FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_mysql \
    zip

WORKDIR /app

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate || true

EXPOSE 8000

CMD php artisan migrate --force && php artisan octane:start --server=frankenphp --host=0.0.0.0 --port=8000