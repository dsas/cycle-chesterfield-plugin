<?php
/**
 * Server-side rendering for the ride grades block.
 *
 * @package CycleChesterfield
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$grades = cycle_chesterfield_get_ride_grades();

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-block-cycle-chesterfield-ride-grades',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<?php foreach ( $grades as $grade ) : ?>
		<div class="wp-block-cycle-chesterfield-ride-grades__item">
			<strong><?php echo esc_html( $grade['title'] ); ?></strong>
			<p><?php echo esc_html( $grade['description'] ); ?></p>
		</div>
	<?php endforeach; ?>
</div>
