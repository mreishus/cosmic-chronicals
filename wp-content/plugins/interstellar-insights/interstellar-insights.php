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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function interstellar_insights_menu() {
	add_menu_page(
		'Interstellar Insights',
		'Interstellar Insights',
		'manage_options',
		'interstellar-insights',
		'interstellar_insights_page',
		'dashicons-star-filled',
		30
	);
	add_submenu_page(
		'interstellar-insights',
		'Cosmic Content Generator',
		'Cosmic Generator',
		'manage_options',
		'interstellar-insights-generator',
		'interstellar_insights_generator_page'
	);
}
add_action( 'admin_menu', 'interstellar_insights_menu' );

function interstellar_insights_page() {
	echo '<div class="wrap">';
	echo '<h1>Interstellar Insights</h1>';

	$content_generated = get_option( 'cosmic_content_generated', false );

	if ( ! $content_generated ) {
		echo '<div class="notice notice-warning">';
		echo '<p>Warning: Test content has not been generated yet. Please generate test content before reading the insights.</p>';
		echo '<p><a href="' . admin_url( 'admin.php?page=interstellar-insights-generator' ) . '" class="button button-primary">Generate Test Content</a></p>';
		echo '</div>';
		echo '</div>';
		return;
	}

	echo interstellar_insights_hello_world();
	echo '</div>';
}

function interstellar_insights_hello_world() {
	$cosmic_facts = get_cosmic_facts();
	$output = '<div class="interstellar-message">';
	$output .= '<h2>Greetings, Earthling! Welcome to the Interstellar Insights.</h2>';
	$output .= '<p>Here are some cosmic facts:</p>';
	$output .= '<ul>';

	foreach ($cosmic_facts as $fact) {
		$output .= "<li><strong>{$fact['title']}</strong> by {$fact['author']}";
		$output .= "<ul>";
		$output .= "<li>Categories: " . implode(', ', $fact['categories']) . "</li>";
		$output .= "<li>Tags: " . (empty($fact['tags']) ? 'None' : implode(', ', $fact['tags'])) . "</li>";
		$output .= "<li>Comment count: {$fact['comment_count']}</li>";
		$output .= "<li>Custom Field 1: {$fact['custom_field1']}</li>";
		$output .= "<li>Custom Field 2: {$fact['custom_field2']}</li>";
		$output .= "<li>Related Posts: " . implode(', ', $fact['related_posts']) . "</li>";
		$output .= "</ul>";
		$output .= "</li>";
	}

	$output .= '</ul>';
	$output .= '</div>';

	return $output;
}

function get_cosmic_facts() {
	$facts = array();
	$recent_posts = get_posts( array(
		'post_status' => 'publish',
		'orderby'     => 'date',
		'order'       => 'DESC',
		'numberposts' => 100
	) );

	foreach ( $recent_posts as $post ) {
		$author = get_userdata( $post->post_author );

		$custom_field1 = get_post_meta( $post->ID, 'custom_field1', true );
		$custom_field2 = get_post_meta( $post->ID, 'custom_field2', true );

		$categories = wp_get_post_terms( $post->ID, 'category' );
		$tags = wp_get_post_terms( $post->ID, 'post_tag' );

		$approved_comments = get_comments( array(
			'post_id' => $post->ID,
			'status' => 'approve'
		) );

		$related_posts = get_posts( array(
			'category__in' => wp_get_post_categories( $post->ID ),
			'numberposts' => 5,
			'post__not_in' => array( $post->ID )
		) );

		$facts[] = array(
			'title'          => $post->post_title,
			'author'         => $author ? $author->display_name : 'Unknown',
			'categories'     => wp_list_pluck( $categories, 'name' ),
			'tags'           => $tags ? wp_list_pluck( $tags, 'name' ) : array(),
			'comment_count'  => count( $approved_comments ),
			'custom_field1'  => $custom_field1,
			'custom_field2'  => $custom_field2,
			'related_posts'  => wp_list_pluck( $related_posts, 'post_title' )
		);
	}
	return $facts;
}

function interstellar_insights_shortcode() {
	return '<p>Check out the <a href="' . admin_url('admin.php?page=interstellar-insights') . '">Interstellar Insights</a> in the admin area!</p>';
}
add_shortcode( 'interstellar_insights', 'interstellar_insights_shortcode' );

function interstellar_insights_admin_notice() {
	echo '<div class="notice notice-info is-dismissible">';
	echo '<p>Check out the <a href="' . admin_url( 'admin.php?page=interstellar-insights' ) . '">Interstellar Insights</a> for some cosmic facts!</p>';
	echo '</div>';
}
add_action( 'admin_notices', 'interstellar_insights_admin_notice' );

function interstellar_insights_generator_page() {
	echo '<div class="wrap">';
	echo '<h1>Cosmic Content Generator</h1>';

	if ( isset( $_POST['generate_cosmic_content'] ) && check_admin_referer( 'generate_cosmic_content_nonce' ) ) {
		generate_cosmic_content();
		echo '<div class="notice notice-success"><p>Cosmic content has been successfully generated!</p></div>';
	}

	$content_generated = get_option( 'cosmic_content_generated', false );

	if ( $content_generated ) {
		echo '<p>The cosmic content has already been generated. Are you sure you want to generate more?</p>';
	} else {
		echo '<p>Welcome, Cosmic Explorer! Press the button below to generate test content for your interstellar journey.</p>';
	}

	echo '<form method="post">';
	wp_nonce_field( 'generate_cosmic_content_nonce' );
	echo '<input type="submit" name="generate_cosmic_content" class="button button-primary" value="Generate Cosmic Content">';
	echo '</form>';

	echo '</div>';
}

function generate_cosmic_content() {
	$cosmic_facts = array(
		"The largest known star, UY Scuti, is about 1,700 times wider than the Sun.",
		"A day on Venus is longer than its year. Venus rotates once every 243 Earth days and orbits the Sun every 225 Earth days.",
		"The Great Red Spot on Jupiter has been raging for at least 400 years.",
		"There are more trees on Earth than stars in the Milky Way. Earth has about 3 trillion trees, while the Milky Way has 100-400 billion stars.",
		"The coldest place in the universe is the Boomerang Nebula, with a temperature of -272°C, just 1°C above absolute zero.",
		"If you could fly a plane to Pluto, it would take more than 800 years.",
		"The biggest known galaxy, IC 1101, is about 50 times the size of the Milky Way and has over 100 trillion stars.",
		"A year on Mercury is just 88 Earth days long.",
		"The largest known structure in the universe is the Hercules-Corona Borealis Great Wall, spanning about 10 billion light-years.",
		"There are more molecules in a glass of water than there are glasses of water in all the oceans on Earth.",
	);

	for ( $i = 1; $i <= 100; $i++ ) {
		$fact_index = $i % count( $cosmic_facts );
		$fact = $cosmic_facts[$fact_index];
		$post_id = wp_insert_post( array(
			'post_title'   => "Cosmic Fact #$i",
			'post_content' => "Did you know? $fact This fascinating cosmic tidbit reminds us of the vast wonders of our universe.",
			'post_status'  => 'publish',
		) );

		// Add a comment to the post
		wp_insert_comment( array(
			'comment_post_ID' => $post_id,
			'comment_content' => "This is comment $i on a cosmic post. It might contain questions about the universe or reactions to the post's content.",
			'comment_author'  => "Space Explorer $i",
		) );
	}

	// Create the Welcome page
	wp_insert_post( array(
		'post_type'    => 'page',
		'post_title'   => 'Greetings, Cosmic Traveler!',
		'post_content' => 'Welcome to the Cosmic Chronicles workshop! Prepare to embark on an interstellar adventure through the vast expanse of WordPress optimization.',
		'post_status'  => 'publish',
	) );

	// Create the About page
	wp_insert_post( array(
		'post_type'    => 'page',
		'post_title'   => 'About Cosmic Chronicles',
		'post_content' => 'Cosmic Chronicles is your gateway to the mysteries of the WordPress universe. In this workshop, you will learn to navigate the asteroid fields of plugin optimization and unlock the secrets of stellar performance.',
		'post_status'  => 'publish',
	) );

	// Create a page to showcase the Interstellar Insights plugin
	wp_insert_post( array(
		'post_type'    => 'page',
		'post_title'   => 'Interstellar Insights Demo',
		'post_content' => 'Welcome to our cosmic demo! [interstellar_insights]',
		'post_status'  => 'publish',
	) );

	update_option( 'cosmic_content_generated', true );
}
