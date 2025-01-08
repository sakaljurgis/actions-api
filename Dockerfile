FROM php:apache

# workaround for laravel public folder (entry file)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# workaround for storage access
ARG UID
RUN if [ -z "${UID}" ] ; then echo UID argument is NOT provided ; else usermod --non-unique --uid 1000 www-data ; fi

# enable mod_rewrite for laravel routing to work (.htaccess)
RUN a2enmod rewrite

COPY . /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
RUN composer install
