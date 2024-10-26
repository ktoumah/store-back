FROM php:8.2-fpm-alpine
LABEL maintainer="Karim TOUMAH"

# Update package lists and install necessary packages
RUN apk add --no-cache --update \
        libcurl \
        libpng \
        libjpeg-turbo \
        libwebp \
        libxpm \
        zlib \
        libzip \
        git \
        openssh \
        openssl \
        bash \
        autoconf \
        gcc \
        make \
        && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        && pecl install mongodb \
        && docker-php-ext-enable mongodb \
        && apk del .build-deps

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony && \
    chmod +x /usr/local/bin/symfony

# Create application directory and set permissions
RUN mkdir -p /var/www/app && \
    chown -R www-data:www-data /var/www

WORKDIR /var/www/app

# Set permissions for the web server user
RUN chown -R www-data:www-data /var/www/app

# Expose the port the app runs on (for use with a reverse proxy)
EXPOSE 80

# Start PHP-FPM
CMD ["php-fpm"]
