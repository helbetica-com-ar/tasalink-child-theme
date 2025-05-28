<?php
/**
 * Theme functions and definitions.
 *
 * For additional information on potential customization options,
 * read the developers' documentation:
 *
 * https://developers.elementor.com/docs/hello-elementor-theme/
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_CHILD_VERSION', '2.0.0' );

/**
 * Load child theme scripts & styles.
 *
 * @return void
 */
function hello_elementor_child_scripts_styles() {

	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		HELLO_ELEMENTOR_CHILD_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_scripts_styles', 20 );




// custom-mortgage-calculator Admin Page for past stored submissions
add_action('admin_menu', 'mortgage_applications_admin_menu');

// Debug: Check if theme is loaded
add_action('init', function() {
    error_log('Hello Theme Child is loaded');
});

function mortgage_applications_admin_menu() {
    error_log('mortgage_applications_admin_menu function called');
    
    add_menu_page(
        'Mortgage Applications',
        'Mortgage Apps', 
        'manage_options',
        'mortgage-applications',
        'mortgage_applications_admin_page',
        'dashicons-list-view', // Add an icon
        30 // Position after Posts/Pages
    );
}

function mortgage_applications_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'mortgage_applications';
    $applications = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC");
    
    echo '<div class="wrap"><h1>Mortgage Applications</h1>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Loan Amount</th><th>Date</th><th>Status</th></tr></thead>';
    echo '<tbody>';
    
    foreach ($applications as $app) {
        echo '<tr>';
        echo '<td>' . $app->id . '</td>';
        echo '<td>' . esc_html($app->full_name) . '</td>';
        echo '<td>' . esc_html($app->email) . '</td>';
        echo '<td>$' . number_format($app->loan_amount, 2) . '</td>';
        echo '<td>' . $app->submission_date . '</td>';
        echo '<td>' . $app->status . '</td>';
        echo '</tr>';
    }
    
    echo '</tbody></table></div>';
}