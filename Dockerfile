FROM php:8.2-apache

# تثبيت مكتبة CURL التي يحتاجها كود الرفع
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install curl

# نسخ ملفات مشروعك إلى مجلد السيرفر
COPY . /var/www/html/

# إعطاء صلاحيات الوصول لـ Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
