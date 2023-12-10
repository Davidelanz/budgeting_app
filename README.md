<h1> Apache on PHP Development Docker Image</h1>

## How to use

Use this image in a `docker-compose.yml` file in order to launch a local server for a PHP-based website:

```yml
version: '3.8'

services:
  test-apache-server:
    image: ghcr.io/eikonproject/apache_dev_server:main
    volumes:
      - <WEBSITE_HTDOCS_FOLDER>:/home/htdocs
    ports:
      - <DESIRED_PORT>:8889
```

## Build locally

The [`docker-compose.yml`](./docker-compose.yml) file included here automatically builds locally the image and provide an example by mounting the [`test-website.org`](./test-website.org/) folder as a test PHP website.
