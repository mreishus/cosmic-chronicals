#!/bin/bash
echo "Stopping and removing containers, networks, volumes, and images..."
docker-compose down -v
echo "Rebuilding and starting containers..."
docker-compose up -d --build
echo "Waiting for WordPress to be ready..."
until docker-compose exec -T wordpress wp core is-installed --allow-root; do
    sleep 5
done
echo "WordPress has been reset and is ready!"
echo "You can access the site at http://localhost:8000"