FROM webdevops/php-nginx:8.2

WORKDIR /app

COPY . /app

RUN composer install --no-dev --optimize-autoloader

RUN php artisan key:generate || true

ENV WEB_DOCUMENT_ROOT=/app/public

EXPOSE 80