FROM php:8.1-cli-alpine

WORKDIR /var/www/html

COPY . .

RUN chown www-data:www-data -R /var/www/html

# install packages for php
#RUN apk add --no-cache bzip2-dev curl-dev libxml2-dev enchant-2

RUN apk add libpq-dev

# install php extensions
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install bcmath sockets pdo_mysql pdo pdo_pgsql pgsql pcntl 
#    ctype \
#    json \
#    mbstring \
#    openssl \
#    pdo \
#    tokenizer \
#    xml

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS && pecl install redis-5.3.7 && docker-php-ext-enable redis.so

# install composer
RUN EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"
RUN if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then >&2 echo 'ERROR: Invalid installer checksum' && rm composer-setup.php && exit 1; fi
RUN php composer-setup.php --quiet
RUN rm composer-setup.php

# install php dependencies
RUN php composer.phar install

# install nodejs
RUN apk add --no-cache nodejs npm

# install node dependencies
RUN npm install

# build application
# RUN npm run production

# install roadrunner
COPY --from=spiralscout/roadrunner:2023.3.2 /usr/bin/rr /usr/bin/rr

# configure roadrunner
RUN php artisan octane:install --server=roadrunner

ENV ROADRUNNER_MAX_REQUESTS=512
ENV ROADRUNNER_WORKERS="auto"

EXPOSE 8000

CMD php artisan octane:start --server="roadrunner" --host="0.0.0.0" --workers=${ROADRUNNER_WORKERS} --max-requests=${ROADRUNNER_MAX_REQUESTS}

HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 CMD php artisan octane:status --server="roadrunner"
