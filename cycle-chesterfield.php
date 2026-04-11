<?php
/**
 * Plugin Name: Cycle Chesterfield
 * Plugin URI:  https://github.com/dsas/cycle-chesterfield-plugin
 * Description: Custom functionality plugin for the Cycle Chesterfield site.
 * Version:     1.0.0
 * Author:      Dean Sas
 * Text Domain: cycle-chesterfield
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

	register_block_type( __DIR__ . '/blocks/ride-grade' );
}
add_action( 'init', 'cycle_chesterfield_register_blocks' );
