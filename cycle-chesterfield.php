<?php
/**
 * Plugin Name: Cycle Chesterfield
 * Plugin URI:  https://github.com/dsas/cycle-chesterfield-plugin
 * Description: Custom functionality plugin for the Cycle Chesterfield site.
 * Version:     1.1.0
 * Author:      Dean Sas
 * Text Domain: cycle-chesterfield
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns ride grade labels and descriptions.
 *
 * @return array<string, array<string, string>>
 */
function cycle_chesterfield_get_ride_grades() {
	return array(
		'1' => array(
			'title'       => __( 'Grade 1 Ride', 'cycle-chesterfield' ),
			'description' => __( 'Mostly level ride on good surfaces, maybe some small hills, under 10 miles. Suitable for all.', 'cycle-chesterfield' ),
		),
		'2' => array(
			'title'       => __( 'Grade 2 Ride', 'cycle-chesterfield' ),
			'description' => __( 'Mostly level ride over 10 miles, some mixed surfaces, maybe some small hills OR a ride with several noticeable gradients / hills but under 10 miles. Suitable for riders with some experience and the ability to cycle over 10 miles or on several noticeable gradients / hills under 10 miles.', 'cycle-chesterfield' ),
		),
		'3' => array(
			'title'       => __( 'Grade 3 Ride', 'cycle-chesterfield' ),
			'description' => __( 'Any ride on mixed terrain with noticeable gradients / hills and over 10 miles. Suitable for the more experienced rider who can maintain an easy moderate pace throughout.', 'cycle-chesterfield' ),
		),
	);
}

/**
 * Registers plugin blocks.
 */
function cycle_chesterfield_register_blocks() {
	$editor_script_dependencies = array(
		'wp-blocks',
		'wp-block-editor',
		'wp-components',
		'wp-element',
		'wp-i18n',
	);

	wp_register_script(
		'cycle-chesterfield-ride-grade-editor',
		plugins_url( 'blocks/ride-grade/index.js', __FILE__ ),
		$editor_script_dependencies,
		filemtime( plugin_dir_path( __FILE__ ) . 'blocks/ride-grade/index.js' ),
		true
	);

	wp_add_inline_script(
		'cycle-chesterfield-ride-grade-editor',
		'window.cycleChesterfieldRideGrades = ' . wp_json_encode( cycle_chesterfield_get_ride_grades() ) . ';',
		'before'
	);

	wp_register_script(
		'cycle-chesterfield-ride-grades-editor',
		plugins_url( 'blocks/ride-grades/index.js', __FILE__ ),
		$editor_script_dependencies,
		filemtime( plugin_dir_path( __FILE__ ) . 'blocks/ride-grades/index.js' ),
		true
	);

	wp_add_inline_script(
		'cycle-chesterfield-ride-grades-editor',
		'window.cycleChesterfieldRideGrades = ' . wp_json_encode( cycle_chesterfield_get_ride_grades() ) . ';',
		'before'
	);

	register_block_type( __DIR__ . '/blocks/ride-grade' );
	register_block_type( __DIR__ . '/blocks/ride-grades' );
}
add_action( 'init', 'cycle_chesterfield_register_blocks' );
