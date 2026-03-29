FROM php:8.2-apache

# تثبيت مكتبات الاتصال وزيادة حجم الملفات المسموح بها
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    ca-certificates \
    && docker-php-ext-install curl

# زيادة الحجم المسموح لرفع الملفات (100 ميجا)
RUN echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/uploads.ini && \
    echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
