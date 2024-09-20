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
}
add_action( 'admin_menu', 'interstellar_insights_menu' );

function interstellar_insights_page() {
	echo '<div class="wrap">';
	echo '<h1>Interstellar Insights</h1>';
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
