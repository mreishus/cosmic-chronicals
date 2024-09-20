<?php
/*
Plugin Name: Galactic Performance Monitor
Description: Monitor performance of galaxy-themed plugins
Version: 1.0
Author: Your Name
*/

// Ensure this file is being run within the WordPress context
if (!defined('ABSPATH')) {
    exit;
}

class Galactic_Performance_Monitor {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'Galactic Performance',
            'Galactic Performance',
            'manage_options',
            'galactic-performance',
            array($this, 'display_admin_page'),
            'dashicons-chart-area'
        );
    }

    public function enqueue_styles($hook) {
        if ($hook != 'toplevel_page_galactic-performance') {
            return;
        }
        wp_enqueue_style('galactic-performance-css', plugin_dir_url(__FILE__) . 'css/galactic-performance.css');
    }

    public function display_admin_page() {
        ?>
        <div class="wrap">
            <h1>Galactic Performance Monitor</h1>
            <div class="performance-check">
                <h2>Interstellar Insights Performance</h2>
                <?php $this->check_cosmic_facts_performance(); ?>
            </div>
        </div>
        <?php
    }

    private function check_cosmic_facts_performance() {
        global $wpdb;

        // Ensure the function exists
        if (!function_exists('get_cosmic_facts')) {
            echo '<p class="error">Error: get_cosmic_facts() function not found. Is the Interstellar Insights plugin active?</p>';
            return;
        }

        $initial_query_count = $wpdb->num_queries;
        
        // Run the function
        $cosmic_facts = get_cosmic_facts();
        
        $final_query_count = $wpdb->num_queries;
        $query_difference = $final_query_count - $initial_query_count;

        echo '<p>Number of queries run by get_cosmic_facts(): ' . $query_difference . '</p>';

        // Performance check
        if ($query_difference > 100) {
            echo '<p class="fail">❌ Performance check failed. Too many queries executed.</p>';
        } else {
            echo '<p class="pass">✅ Performance check passed.</p>';
        }
    }
}

// Initialize the plugin
new Galactic_Performance_Monitor();
