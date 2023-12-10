# https://github.com/docker-library/php/blob/dd8ca598756729ec69591046750ee6b49099d067/8.1/bookworm/apache/Dockerfile
FROM php:8.1-apache

LABEL org.opencontainers.image.authors="davide.lanza@eikonproject.org"
LABEL org.opencontainers.image.description "Apache on PHP 7.4 Development Docker Image"

# Copy configuration files
COPY ports.conf /etc/apache2/ports.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Set workdir to /home/htdocs (the apache DocumentRoot specified in 000-default.conf)
RUN mkdir -p /home/htdocs && \
    chown -R $USER:$USER /home/htdocs && \
    chmod -R 755 /home/htdocs
WORKDIR /home/htdocs

# Expose the default website port
EXPOSE 8889

# Allow rewrite
RUN a2enmod rewrite
