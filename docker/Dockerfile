FROM php:8.1.0-fpm

ARG APCU_VERSION=5.1.18


LABEL Maintainer="Hamdi GARFI " \
      Description=" PHP and PostgreSQL."

# Arguments defined in docker-compose.yml
ARG user=user1
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    vim

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get update

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mbstring exif pcntl bcmath gd

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user 

# Set working directory
WORKDIR /var/www
# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

USER $user

EXPOSE 8080

CMD ["php-fpm"]
