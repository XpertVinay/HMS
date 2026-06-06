FROM php:8.4-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo_mysql zip \
    && docker-php-ext-enable mysqli pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN apt-get update && apt-get install -y curl unzip git

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Change Apache to listen on port 8080 and set DocumentRoot to public/
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf \
    && sed -i 's/\*:80/\*:8080/g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<\/VirtualHost>/i \    <Directory /var/www/html/public>\n        AllowOverride All\n        Require all granted\n    </Directory>' /etc/apache2/sites-available/000-default.conf

# Copy project files
COPY . /var/www/html/

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install PHP dependencies
WORKDIR /var/www/html
RUN composer install --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

# Use the custom entrypoint script
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
