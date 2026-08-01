<?php
/**
 * Ride grade blocks and shared grade data.
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
 * Returns a valid ride grade, if one has been assigned to an event.
 *
 * @param int $event_id Event post ID.
 * @return string Empty when the event has no valid ride grade.
 */
function cycle_chesterfield_get_event_ride_grade( $event_id ) {
	$grade  = (string) get_post_meta( $event_id, '_cycle_chesterfield_ride_grade', true );
	$grades = cycle_chesterfield_get_ride_grades();

	return isset( $grades[ $grade ] ) ? $grade : '';
}

/**
 * Sanitizes the ride grade stored on an event.
 *
 * @param mixed $value Meta value.
 * @return string A valid grade or an empty value for no grade.
 */
function cycle_chesterfield_sanitize_event_ride_grade( $value ) {
	$grade  = sanitize_text_field( $value );
	$grades = cycle_chesterfield_get_ride_grades();

	return isset( $grades[ $grade ] ) ? $grade : '';
}

/**
 * Renders the compact ride grade label used in event listings.
 *
 * @param int  $event_id Event post ID.
 * @param bool $inline   Whether to use an inline wrapper.
 * @return string
 */
function cycle_chesterfield_get_event_ride_grade_label( $event_id, $inline = false ) {
	$grade = cycle_chesterfield_get_event_ride_grade( $event_id );

	if ( '' === $grade ) {
		return '';
	}

	$grades           = cycle_chesterfield_get_ride_grades();
	$ride_grades_page = get_page_by_path( 'ride-grades' );
	$ride_grades_link = $ride_grades_page instanceof WP_Post ? get_permalink( $ride_grades_page ) : '';

	ob_start();
	?>
	<?php if ( $inline ) : ?>
	<span class="cycle-chesterfield-event-ride-grade tribe-common-b2">
	<?php else : ?>
	<div class="cycle-chesterfield-event-ride-grade tribe-common-b2">
	<?php endif; ?>
		<?php echo esc_html( $grades[ $grade ]['title'] ); ?>
		<?php if ( $ride_grades_link ) : ?>
			<a
				href="<?php echo esc_url( $ride_grades_link ); ?>"
				aria-label="<?php esc_attr_e( 'Learn more about ride grades', 'cycle-chesterfield' ); ?>"
				title="<?php esc_attr_e( 'Learn more about ride grades', 'cycle-chesterfield' ); ?>"
			><?php echo esc_html( ' ⓘ' ); ?></a>
		<?php endif; ?>
	<?php if ( $inline ) : ?>
	</span>
	<?php else : ?>
	</div>
	<?php endif; ?>
	<?php

	return (string) ob_get_clean();
}

/**
 * Gets the ride grade selected in a ride-grade block.
 *
 * @param array<int, array<string, mixed>> $blocks Parsed blocks.
 * @return string Empty when no valid grade block is present.
 */
function cycle_chesterfield_get_ride_grade_from_blocks( $blocks ) {
	$grades = cycle_chesterfield_get_ride_grades();

	foreach ( $blocks as $block ) {
		if ( 'cycle-chesterfield/ride-grade' === $block['blockName'] ) {
			$grade = isset( $block['attrs']['grade'] ) ? (string) $block['attrs']['grade'] : '';

			return isset( $grades[ $grade ] ) ? $grade : '';
		}

		if ( ! empty( $block['innerBlocks'] ) ) {
			$grade = cycle_chesterfield_get_ride_grade_from_blocks( $block['innerBlocks'] );

			if ( '' !== $grade ) {
				return $grade;
			}
		}
	}

	return '';
}

/**
 * Keeps the event meta used by listings in sync with the ride-grade block.
 *
 * Events without the block intentionally have no stored grade.
 *
 * @param int     $post_id Event post ID.
 * @param WP_Post $post    Event post.
 * @return void
 */
function cycle_chesterfield_sync_event_ride_grade( $post_id, $post ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}

	$grade = cycle_chesterfield_get_ride_grade_from_blocks( parse_blocks( $post->post_content ) );

	if ( '' === $grade ) {
		delete_post_meta( $post_id, '_cycle_chesterfield_ride_grade' );
		return;
	}

	update_post_meta( $post_id, '_cycle_chesterfield_ride_grade', $grade );
}
add_action( 'save_post_tribe_events', 'cycle_chesterfield_sync_event_ride_grade', 10, 2 );

/**
 * Backfills event grade meta from existing ride-grade blocks once per site.
 *
 * @return void
 */
function cycle_chesterfield_migrate_event_ride_grades() {
	if ( get_option( 'cycle_chesterfield_ride_grade_meta_version' ) ) {
		return;
	}

	$event_ids = get_posts(
		array(
			'post_type'      => 'tribe_events',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	foreach ( $event_ids as $event_id ) {
		$post = get_post( $event_id );

		if ( $post instanceof WP_Post ) {
			cycle_chesterfield_sync_event_ride_grade( $event_id, $post );
		}
	}

	update_option( 'cycle_chesterfield_ride_grade_meta_version', '1', false );
}
add_action( 'admin_init', 'cycle_chesterfield_migrate_event_ride_grades' );

/**
 * Adds the ride grade to the Events List widget used on the homepage.
 *
 * @param string              $hook_name        Current template hook name.
 * @param string              $entry_point_name Current entry point name.
 * @param Tribe__Template     $template         Event template instance.
 * @return void
 */
function cycle_chesterfield_render_widget_event_ride_grade( $hook_name, $entry_point_name, $template ) {
	$context = $template->get_values();
	$event   = isset( $context['event'] ) ? $context['event'] : null;

	if ( $event instanceof WP_Post ) {
		echo cycle_chesterfield_get_event_ride_grade_label( $event->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped HTML.
	}
}
add_action(
	'tribe_template_entry_point:events/v2/widgets/widget-events-list/event:event_meta',
	'cycle_chesterfield_render_widget_event_ride_grade',
	10,
	3
);

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

	$plugin_base_file = dirname( __DIR__ ) . '/cycle-chesterfield.php';
	$plugin_base_path = dirname( __DIR__ ) . '/';

	register_post_meta(
		'tribe_events',
		'_cycle_chesterfield_ride_grade',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'cycle_chesterfield_sanitize_event_ride_grade',
			'auth_callback'     => static function ( $allowed, $meta_key, $object_id ) {
				return current_user_can( 'edit_post', $object_id );
			},
		)
	);

	wp_register_script(
		'cycle-chesterfield-ride-grade-editor',
		plugins_url( 'blocks/ride-grade/index.js', $plugin_base_file ),
		$editor_script_dependencies,
		filemtime( $plugin_base_path . 'blocks/ride-grade/index.js' ),
		true
	);

	wp_add_inline_script(
		'cycle-chesterfield-ride-grade-editor',
		'window.cycleChesterfieldRideGrades = ' . wp_json_encode( cycle_chesterfield_get_ride_grades() ) . ';',
		'before'
	);

	wp_register_script(
		'cycle-chesterfield-ride-grades-editor',
		plugins_url( 'blocks/ride-grades/index.js', $plugin_base_file ),
		$editor_script_dependencies,
		filemtime( $plugin_base_path . 'blocks/ride-grades/index.js' ),
		true
	);

	wp_add_inline_script(
		'cycle-chesterfield-ride-grades-editor',
		'window.cycleChesterfieldRideGrades = ' . wp_json_encode( cycle_chesterfield_get_ride_grades() ) . ';',
		'before'
	);

	register_block_type( $plugin_base_path . 'blocks/ride-grade' );
	register_block_type( $plugin_base_path . 'blocks/ride-grades' );
}
add_action( 'init', 'cycle_chesterfield_register_blocks' );
