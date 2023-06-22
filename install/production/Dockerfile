FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    iputils-ping \
    zip \
    unzip \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    intl \
    zip \
    && a2enmod \
    rewrite \
    headers 

# Clone the repo
RUN apt-get -y install git

RUN git config --global --add safe.directory '*'
RUN git clone https://github.com/ClrGe/vide-grenier.git .
RUN git checkout -f main
RUN git pull

COPY ./pull.sh /var/www/html

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN COMPOSER_ALLOW_SUPERUSER=1  composer install

#RUN apt-get install -y nodejs \
#    npm   

#RUN npm install
