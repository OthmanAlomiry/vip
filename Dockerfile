FROM php:8.2-apache

# تثبيت مكتبة CURL و OpenSSL للاتصال الآمن
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    ca-certificates \
    && docker-php-ext-install curl

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
