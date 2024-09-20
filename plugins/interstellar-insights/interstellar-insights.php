<?php
/**
 * Plugin Name: Interstellar Insights
 * Plugin URI: https://example.com/interstellar-insights
 * Description: A cosmic "Hello World" plugin for testing purposes.
 * Version: 1.0
 * Author: Cosmic Chronicals
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: interstellar-insights
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function interstellar_insights_hello_world() {
    return '<div class="interstellar-message">Greetings, Earthling! Welcome to the Interstellar Insights.</div>';
}

function interstellar_insights_shortcode() {
    return interstellar_insights_hello_world();
}
add_shortcode('interstellar_insights', 'interstellar_insights_shortcode');

function interstellar_insights_admin_notice() {
    echo '<div class="notice notice-info is-dismissible">';
    echo '<p>' . interstellar_insights_hello_world() . '</p>';
    echo '</div>';
}
add_action('admin_notices', 'interstellar_insights_admin_notice');
