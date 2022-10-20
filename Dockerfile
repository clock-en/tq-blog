FROM php:7.4-apache

COPY ./.prod/php.ini /usr/local/etc/php/
COPY ./.prod/000-default.conf /etc/apache2/sites-enabled/

RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer \
	&& apt-get update \ 
	&& docker-php-ext-install pdo_mysql

COPY src /var/www

WORKDIR /var/www

RUN cd /var/www && rm -rf ./html \
	&& composer --ignore-platform-reqs install

ENV PORT 80
