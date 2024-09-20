#!/bin/bash
docker-compose up -d
echo "Waiting for WordPress to be ready..."
until docker-compose exec -T wordpress wp core is-installed --allow-root; do
    sleep 5
done
echo "WordPress is ready!"
echo "You can access the site at http://localhost:8000"