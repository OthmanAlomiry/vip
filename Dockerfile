FROM php:8.2-apache

# نسخ جميع الملفات للمجلد الرئيسي للسيرفر
COPY . /var/www/html/

# إنشاء مجلد الرفع وإعطاؤه الصلاحيات الكاملة لـ Apache
RUN mkdir -p /var/www/html/uploads && \
    chown -R www-data:www-data /var/www/html/ && \
    chmod -R 775 /var/www/html/uploads

# تفعيل مود rewrite إذا احتجت له لاحقاً
RUN a2enmod rewrite

EXPOSE 80
