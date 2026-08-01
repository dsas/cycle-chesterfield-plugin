<?php
/**
 * Event date in the Events Calendar list view.
 *
 * Adds the optional ride grade after the event date/time. Based on The Events
 * Calendar's `views/v2/list/event/date.php` template.
 *
 * @var WP_Post $event The event post object.
 */

use Tribe__Date_Utils as Dates;

$event_date_attr = $event->dates->start->format( Dates::DBDATEFORMAT );
?>
<div class="tribe-events-calendar-list__event-datetime-wrapper tribe-common-b2">
	<?php $this->template( 'list/event/date/featured' ); ?>
	<time class="tribe-events-calendar-list__event-datetime" datetime="<?php echo esc_attr( $event_date_attr ); ?>">
		<?php echo $event->schedule_details->value(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- The Events Calendar supplies the escaped schedule. ?>
	</time>
	<?php if ( cycle_chesterfield_get_event_ride_grade( $event->ID ) ) : ?>
		<span aria-hidden="true"> · </span>
		<?php echo cycle_chesterfield_get_event_ride_grade_label( $event->ID, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Helper returns escaped HTML. ?>
	<?php endif; ?>
	<?php $this->template( 'list/event/date/meta', [ 'event' => $event ] ); ?>
</div>
