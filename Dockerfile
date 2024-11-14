FROM php:8.3-fpm-alpine
<<<<<<< HEAD
RUN apt_get update && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/user/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql mbstring


WORKDIR /app
COPY composer.json .
RUN composer install --no--scripts
COPY . .
CMD php artisan serve --host=0.0.0.0 --port 80
=======

RUN apk add --no-cache nginx wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
>>>>>>> c046a345a9cc139e2516c24a13b90b0ceafc2c61
