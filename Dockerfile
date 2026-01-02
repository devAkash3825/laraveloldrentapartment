# # Use the official PHP image with Apache
# FROM php:8.2-apache

# # Set the working directory in the container
# WORKDIR /var/www/html

# # Install necessary packages and PHP extensions
# RUN apt-get update && apt-get install -y \
#         libzip-dev \
#         unzip \
#         && docker-php-ext-install \
#         mysqli pdo pdo_mysql zip \
#         && apt-get clean

# # Install Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # Copy the project files to the container
# COPY . .

# # Install PHP dependencies via Composer
# RUN composer install --no-dev --optimize-autoloader

# # Enable Apache mod_rewrite if needed (often used for Laravel, WordPress, etc.)
# RUN a2enmod rewrite

# # Set the Apache DocumentRoot to the public folder
# RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# # Ensure the public directory has the right permissions
# RUN chown -R www-data:www-data /var/www/html/ \
#     && chmod -R 755 /var/www/html/ 


# # Expose the port Apache is running on
# EXPOSE 80

# # Start Apache in the foreground
# CMD ["apache2-foreground"]


# Use the official PHP image with Apache
FROM php:8.2-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Install necessary packages, PHP extensions, and Composer in one layer
RUN apt-get update && apt-get install -y \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        mysqli pdo pdo_mysql zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Copy the project files to the container
COPY . .

# Install PHP dependencies via Composer
# RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the Apache DocumentRoot to the public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copy custom opcache configuration
COPY ./opcache.ini /usr/local/etc/php/conf.d/

# Ensure the public directory has the right permissions
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Expose the port Apache is running on
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
