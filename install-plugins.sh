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

# Sample posts with cosmic facts
cosmic_facts=(
    "The largest known star, UY Scuti, is about 1,700 times wider than the Sun."
    "A day on Venus is longer than its year. Venus rotates once every 243 Earth days and orbits the Sun every 225 Earth days."
    "The Great Red Spot on Jupiter has been raging for at least 400 years."
    "There are more trees on Earth than stars in the Milky Way. Earth has about 3 trillion trees, while the Milky Way has 100-400 billion stars."
    "The coldest place in the universe is the Boomerang Nebula, with a temperature of -272°C, just 1°C above absolute zero."
    "If you could fly a plane to Pluto, it would take more than 800 years."
    "The biggest known galaxy, IC 1101, is about 50 times the size of the Milky Way and has over 100 trillion stars."
    "A year on Mercury is just 88 Earth days long."
    "The largest known structure in the universe is the Hercules-Corona Borealis Great Wall, spanning about 10 billion light-years."
    "There are more molecules in a glass of water than there are glasses of water in all the oceans on Earth."
)

for i in {1..100}
do
   fact_index=$((i % ${#cosmic_facts[@]}))
   fact="${cosmic_facts[$fact_index]}"
   wp post create --post_type=post --post_title="Cosmic Fact #$i" --post_content="Did you know? $fact This fascinating cosmic tidbit reminds us of the vast wonders of our universe." --post_status=publish --allow-root
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
