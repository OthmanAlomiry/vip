FROM php:8.2-apache

# زيادة حجم الرفع المسموح في PHP
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini

# تثبيت مكتبة CURL
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install curl

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
EXPOSE 80
