<?php
/**
 * Customizations for hiding ride end times in The Events Calendar.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hides ride end times in The Events Calendar views.
 *
 * End times are still stored so the calendar can use them internally.
 *
 * @param array<string> $views Views where end times should be hidden.
 * @return array<string>
 */
function cycle_chesterfield_hide_event_end_times_in_views( $views ) {
	return array_unique(
		array_merge(
			(array) $views,
			array( 'single-event', 'day', 'list', 'month', 'recent' )
		)
	);
}
add_filter( 'tribe_get_option_remove_event_end_time', 'cycle_chesterfield_hide_event_end_times_in_views' );

/**
 * Hides ride end times in schedule strings, including shortcode output.
 *
 * @param array<string, bool> $settings Schedule formatting settings.
 * @return array<string, bool>
 */
function cycle_chesterfield_hide_event_end_times_in_schedules( $settings ) {
	$settings['show_end_time'] = false;

	return $settings;
}
add_filter( 'tribe_events_event_schedule_details_formatting', 'cycle_chesterfield_hide_event_end_times_in_schedules', 20 );

/**
 * Shows only the ride start time in the single-event details panel.
 *
 * @param string $time_formatted Existing formatted time range.
 * @param int    $event_id       Event post ID.
 * @return string
 */
function cycle_chesterfield_show_event_start_time_in_details( $time_formatted, $event_id ) {
	return esc_html( tribe_get_start_date( $event_id, false, get_option( 'time_format' ) ) );
}
add_filter( 'tribe_events_single_event_time_formatted', 'cycle_chesterfield_show_event_start_time_in_details', 10, 2 );

/**
 * Hides the end time in the event date-time block.
 *
 * @param string $html Rendered block HTML.
 * @return string
 */
function cycle_chesterfield_hide_event_end_time_in_block( $html ) {
	$end_time_pattern = '~<span class="tribe-events-schedule__time tribe-events-schedule__time--end">\s*[^<]*\s*</span>\s*~';
	$date_separator_pattern = '~<span class="tribe-events-schedule__separator tribe-events-schedule__separator--date">\s*[^<]*\s*</span>\s*(?=<span class="tribe-events-schedule__time tribe-events-schedule__time--end">)~';

	$html = preg_replace( $date_separator_pattern, '', $html );
	$html = preg_replace( $end_time_pattern, '', $html );

	if ( false === strpos( $html, 'tribe-events-schedule__date--end' ) ) {
		$time_separator_pattern = '~<span class="tribe-events-schedule__separator tribe-events-schedule__separator--time">\s*[^<]*\s*</span>\s*~';
		$html = preg_replace( $time_separator_pattern, '', $html );
	}

	return $html;
}
add_filter( 'tribe_template_html:events/blocks/event-datetime', 'cycle_chesterfield_hide_event_end_time_in_block' );

/**
 * Hides the end time in widget events list date output.
 *
 * This targets markup like:
 * <span class="tribe-event-date-start">6:30 pm</span> - <span class="tribe-event-time">7:30 pm</span>
 *
 * @param string $html Rendered template HTML.
 * @return string
 */
function cycle_chesterfield_hide_event_end_time_in_widget_list( $html ) {
	$end_time_pattern = '~\s*[\-\x{2013}\x{2014}]\s*<span class="tribe-event-time">\s*[^<]*\s*</span>~u';

	return preg_replace( $end_time_pattern, '', $html );
}
add_filter( 'tribe_template_html:events/v2/widgets/widget-events-list/event/date', 'cycle_chesterfield_hide_event_end_time_in_widget_list' );
add_filter( 'tribe_template_html:widgets/widget-events-list/event/date', 'cycle_chesterfield_hide_event_end_time_in_widget_list' );
