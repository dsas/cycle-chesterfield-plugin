<?php
/**
 * Plugin Name: Cycle Chesterfield
 * Plugin URI:  https://github.com/dsas/cycle-chesterfield-plugin
 * Description: Custom functionality plugin for the Cycle Chesterfield site.
 * Version:     1.2.0
 * Author:      Dean Sas
 * Text Domain: cycle-chesterfield
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once __DIR__ . '/includes/ride-grades.php';
require_once __DIR__ . '/includes/hide-event-end-times.php';
