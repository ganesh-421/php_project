FROM alpine:latest

# latest alpine
RUN apk update

RUN apk add --no-cache
RUN apk add php \
    php-cli \
    php-fpm \
    php-session \
    php-mysqli \
    php-pdo \
    php-pdo_mysql \
    php-mbstring \
    php-openssl \
    php-tokenizer \
    php-xml \
    php-json \
    php-phar \
    php-ctype \
    php-curl \
    php-bcmath \
    curl \
    bash \  
    git \
    supervisor

RUN apk add apache2

WORKDIR /var/www/html

COPY . /var/www/html

RUN httpd

EXPOSE 8000

CMD ["php", "-S",  "0.0.0.0:8000", "-t", "/var/www/html/public"]