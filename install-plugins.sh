#!/bin/bash

# Wait for WordPress to be ready
until $(wp core is-installed --allow-root); do
    echo "Waiting for WordPress to be ready..."
    sleep 5
done

# Set the site title
wp option update blogname "Cosmic Chronicals" --allow-root

# Activate plugins from the /var/www/html/wp-content/plugins directory
for plugin_dir in /var/www/html/wp-content/plugins/*; do
    if [ -d "$plugin_dir" ]; then
        plugin_name=$(basename "$plugin_dir")
        echo "Activating plugin: $plugin_name"
        wp plugin activate "$plugin_name" --allow-root
    fi
done

# Install and activate W3 Total Cache
# wp plugin install w3-total-cache --activate --allow-root

# Install and activate a specific theme (e.g., Twenty Twenty-One)
#wp theme install twentytwentyone --activate --allow-root

# Sample posts
for i in {1..100}
do
   wp post create --post_type=post --post_title="Cosmic Post $i" --post_content="This is the content of cosmic post $i. It contains some astronomical facts and interstellar theories." --post_status=publish --allow-root
done

# Sample comments
for i in {1..100}
do
   POST_ID=$((RANDOM % 100 + 1))
   wp comment create --comment_post_ID=$POST_ID --comment_content="This is comment $i on a cosmic post. It might contain questions about the universe or reactions to the post's content." --comment_author="Space Explorer $i" --allow-root
done

# Create the Welcome page
wp post create --post_type=page --post_title='Greetings, Cosmic Traveler!' --post_content='Welcome to the Cosmic Chronicles workshop! Prepare to embark on an interstellar adventure through the vast expanse of WordPress optimization.' --post_status=publish --allow-root

# Create the About page
wp post create --post_type=page --post_title='About Cosmic Chronicles' --post_content='Cosmic Chronicles is your gateway to the mysteries of the WordPress universe. In this workshop, you will learn to navigate the asteroid fields of plugin optimization and unlock the secrets of stellar performance.' --post_status=publish --allow-root

# Install and activate your custom plugin (replace with actual plugin name)
# wp plugin install your-custom-plugin --activate --allow-root

# Create a page to showcase the Interstellar Insights plugin
wp post create --post_type=page --post_title='Interstellar Insights Demo' --post_content='Welcome to our cosmic demo! [interstellar_insights]' --post_status=publish --allow-root

touch /var/www/html/wp-content/plugins_installed
