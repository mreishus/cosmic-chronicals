#!/bin/bash
export UID=$(id -u)
export GID=$(id -g)
docker-compose up --build -d
echo "Waiting for WordPress to be ready..."
until docker-compose exec -T wordpress wp core is-installed --allow-root; do
    sleep 5
done
echo "WordPress core is installed. Waiting for plugins and sample content (We are adding 100 posts, be patient)..."
until docker-compose exec -T wordpress test -f /var/www/html/wp-content/plugins_installed; do
    sleep 5
done
echo ""
echo "================="
echo "WordPress is ready!"
echo "You can access the site at http://localhost:9876 or http://localhost:9876/wp-admin"
echo "The username:password is admin:password."
echo ""
echo "You can edit the plugins by modifying the files in the plugins directory:"
echo "$(pwd)/plugins"
echo "Any changes you make will be immediately reflected in the WordPress installation."
echo "================="
