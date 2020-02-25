FROM php:7.4-cli

# Install system packages for PHP extensions
RUN apt-get update && \
    apt-get -y install \
            #g++ \
            #git \
            #curl \
            #imagemagick \
            #libcurl3-dev \
            #libicu-dev \
            #libfreetype6-dev \
            #libjpeg-dev \
            #libjpeg62-turbo-dev \
            #libmagickwand-dev \
            #libpq-dev \
            #libpng-dev \
            libxml2-dev \
            libzip-dev \
            libsodium-dev \
            #zlib1g-dev \
            #mariadb-client \
            #openssh-client \
            #nano \
            unzip \
            #libcurl4-openssl-dev \
            #libssl-dev \
        --no-install-recommends && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN docker-php-ext-install \
        soap \
        zip

# Install PECL extensions
# see http://stackoverflow.com/a/8154466/291573) for usage of `printf`
#RUN printf "\n" | pecl install \
#        libsodium && \
#    docker-php-ext-enable \
#        libsodium
        
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
    composer clear-cache

COPY  . /usr/src/user_account
WORKDIR /usr/src/user_account

CMD [ "/bin/bash","-c"]
