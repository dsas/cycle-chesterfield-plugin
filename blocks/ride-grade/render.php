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

$ride_grades_page = get_page_by_path( 'ride-grades' );
$ride_grades_link = $ride_grades_page instanceof WP_Post ? get_permalink( $ride_grades_page ) : '';

$wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'wp-block-cycle-chesterfield-ride-grade',
	)
);
?>
<div <?php echo $wrapper_attributes; ?>>
	<p>
		<strong><?php echo esc_html( $grades[ $grade ]['title'] ); ?></strong>
		<?php if ( $ride_grades_link ) : ?>
			<a
				href="<?php echo esc_url( $ride_grades_link ); ?>"
				aria-label="<?php esc_attr_e( 'Learn more about ride grades', 'cycle-chesterfield' ); ?>"
				title="<?php esc_attr_e( 'Learn more about ride grades', 'cycle-chesterfield' ); ?>"
			><?php echo esc_html( ' ⓘ' ); ?></a>
		<?php endif; ?>
	</p>
	<p>
		<?php echo esc_html( $grades[ $grade ]['description'] ); ?>
	</p>
</div>
