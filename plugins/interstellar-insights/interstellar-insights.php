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

function interstellar_insights_hello_world() {
	$cosmic_facts = get_cosmic_facts();

	$output = '<div class="interstellar-message">Greetings, Earthling! Welcome to the Interstellar Insights.<br>';
	$output .= 'Here are some cosmic facts:<ul>';
	foreach ( $cosmic_facts as $fact ) {
		$output .= "<li>{$fact['title']} by {$fact['author']}</li>";
	}
	$output .= '</ul></div>';

	return $output;
}

function get_cosmic_facts() {
	$facts = array();
	$recent_posts = get_posts( array(
		'post_status' => 'publish',
		'orderby'	  => 'date',
		'order'		  => 'DESC',
		'numberposts' => 100
	) );

	foreach ( $recent_posts as $post ) {
		$author		= get_userdata( $post->post_author );
		$categories = get_the_category( $post->ID );
		$tags		= get_the_tags( $post->ID );

		$facts[] = array(
			'title'			=> $post->post_title,
			'author'		=> $author ? $author->display_name : 'Unknown',
			'categories'	=> wp_list_pluck( $categories, 'name' ),
			'tags'			=> $tags ? wp_list_pluck( $tags, 'name' ) : array(),
			'comment_count' => get_comments_number( $post->ID )
		);
	}

	return $facts;
}

//add_shortcode( 'interstellar_insights', 'interstellar_insights_shortcode' );
add_shortcode( 'interstellar_insights', 'interstellar_insights_hello_world' );

function interstellar_insights_admin_notice() {
	echo '<div class="notice notice-info is-dismissible">';
	echo '<p>' . interstellar_insights_hello_world() . '</p>';
	echo '</div>';
}
add_action( 'admin_notices', 'interstellar_insights_admin_notice' );
