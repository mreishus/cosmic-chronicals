#!/bin/bash
set -e

WP_SRC="/usr/src/wordpress"
WP_PATH="/var/www/html"

# Function to copy WordPress files
copy_wordpress() {
    if [ ! -f "$WP_PATH/wp-includes/version.php" ]; then
        echo "WordPress core files not found. Copying from $WP_SRC to $WP_PATH"
        cp -an $WP_SRC/. $WP_PATH
        echo "Copying complete. Ensuring correct ownership..."
        chown -R www-data:www-data $WP_PATH
    else
        echo "WordPress core files already present in $WP_PATH"
    fi
}

# Function to wait for the database
wait_for_db() {
    until wp db check --allow-root --path="$WP_PATH"; do
        echo "Waiting for database connection..."
        sleep 5
    done
}

# Function to install WordPress
install_wordpress() {
    wp core install \
        --path="$WP_PATH" \
        --url=http://localhost:8000 \
        --title='Cosmic Chronicals' \
        --admin_user=admin \
        --admin_password=password \
        --admin_email=admin@example.com \
        --skip-email \
        --allow-root
}

# Function to run custom plugin installation
install_plugins() {
    if [ -f /usr/local/bin/install-plugins.sh ]; then
        /usr/local/bin/install-plugins.sh
    else
        echo "Warning: install-plugins.sh not found"
    fi
}

# Check if WordPress is installed by looking for a specific option in the database
is_wordpress_installed() {
    wp option get siteurl --allow-root --path="$WP_PATH" > /dev/null 2>&1
}

# Main execution
copy_wordpress

if ! is_wordpress_installed; then
    echo "WordPress is not installed. Installing now..."
    wait_for_db
    install_wordpress
    install_plugins
    echo "WordPress installation complete."
else
    echo "WordPress is already installed."
fi

# Start Apache
exec apache2-foreground
