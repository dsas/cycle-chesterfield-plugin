<?php
/**
 * Server-side rendering for the ride grade block.
 *
 * @package CycleChesterfield
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$descriptions = array(
	'1' => __( 'Mostly level ride on good surfaces, maybe some small hills, under 10 miles. Suitable for all', 'cycle-chesterfield' ),
	'2' => __( 'Mostly level ride over 10 miles, some mixed surfaces, maybe some small hills OR a ride with several noticeable gradients / hills but under 10 miles. Suitable for riders with some experience and the ability to cycle over 10 miles or on several noticeable gradients / hills under 10 miles', 'cycle-chesterfield' ),
	'3' => __( 'Any ride on mixed terrain with noticeable gradients / hills and over 10 miles. Suitable for the more experienced rider who can maintain an easy moderate pace throughout.', 'cycle-chesterfield' ),
);

$grade = isset( $attributes['grade'] ) ? (string) $attributes['grade'] : '1';

if ( ! isset( $descriptions[ $grade ] ) ) {
	$grade = '1';
}

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-block-cycle-chesterfield-ride-grade',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<strong><?php echo esc_html( sprintf( __( 'Grade %s Ride', 'cycle-chesterfield' ), $grade ) ); ?></strong>
	<p><?php echo esc_html( $descriptions[ $grade ] ); ?></p>
</div>
