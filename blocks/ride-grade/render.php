<?php
/**
 * Server-side rendering for the ride grade block.
 *
 * @package CycleChesterfield
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$grades = cycle_chesterfield_get_ride_grades();

$grade = isset( $attributes['grade'] ) ? (string) $attributes['grade'] : '1';

if ( ! isset( $grades[ $grade ] ) ) {
	$grade = '1';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-block-cycle-chesterfield-ride-grade',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<strong><?php echo esc_html( $grades[ $grade ]['title'] ); ?></strong>
	<p><?php echo esc_html( $grades[ $grade ]['description'] ); ?></p>
</div>
