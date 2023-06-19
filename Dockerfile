FROM php:8.2-apache

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite

RUN apt-get update && apt-get install

COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install Composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY my-apache.conf /etc/apache2/sites-available/000-default.conf