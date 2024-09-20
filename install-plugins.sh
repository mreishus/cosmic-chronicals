#!/bin/bash

# Wait for WordPress to be ready
until $(wp core is-installed --allow-root); do
    echo "Waiting for WordPress to be ready..."
    sleep 5
done

# Set the site title
wp option update blogname "Cosmic Chronicals" --allow-root

# Install and activate W3 Total Cache
# wp plugin install w3-total-cache --activate --allow-root

# Install and activate a specific theme (e.g., Twenty Twenty-One)
#wp theme install twentytwentyone --activate --allow-root

# Create the Welcome page
wp post create --post_type=page --post_title='Greetings, Cosmic Traveler!' --post_content='Welcome to the Cosmic Chronicles workshop! Prepare to embark on an interstellar adventure through the vast expanse of WordPress optimization.' --post_status=publish --allow-root

# Create the About page
wp post create --post_type=page --post_title='About Cosmic Chronicles' --post_content='Cosmic Chronicles is your gateway to the mysteries of the WordPress universe. In this workshop, you will learn to navigate the asteroid fields of plugin optimization and unlock the secrets of stellar performance.' --post_status=publish --allow-root

# Install and activate your custom plugin (replace with actual plugin name)
# wp plugin install your-custom-plugin --activate --allow-root
