FROM php:8.2-apache

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Matikan MPM lain biar gak bentrok
RUN a2dismod mpm_event && a2enmod mpm_prefork

# Install ekstensi MySQL
RUN docker-php-ext-install mysqli

# Copy semua file ke web root
COPY . /var/www/html/

# Permission
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

