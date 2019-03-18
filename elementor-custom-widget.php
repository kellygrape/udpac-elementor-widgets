<?php
/**
 * Plugin Name: UDPAC - Elementor Custom Widgets
 * Description: Basic Boilerplate for Custom widgets added to Elementor
 */
if ( ! defined( 'ABSPATH' ) ) exit;
define('ECW_PLUGIN_PLUGIN_PATH', plugin_dir_path( __FILE__ ));


// plug it in
add_action('plugins_loaded', 'ecw_require_files');
function ecw_require_files() {
    require_once ECW_PLUGIN_PLUGIN_PATH.'modules.php';
}


// enqueue your custom style/script as your requirements
// add_action( 'wp_enqueue_scripts', 'ecw_enqueue_styles', 25);
function ecw_enqueue_styles() {
    wp_enqueue_style( 'elementor-custom-widget-editor', ECW_PLUGIN_PLUGIN_PATH( __FILE__ ) . 'assets/css/editor.css');
}


/* Addition - registering dynamic tags per elementor documentation */
add_action( 'elementor/dynamic_tags/register_tags', function( $dynamic_tags ) {
	// In our Dynamic Tag we use a group named request-variables so we need
	// To register that group as well before the tag
	\Elementor\Plugin::$instance->dynamic_tags->register_group( 'udpac-fields', [
		'title' => 'UDPAC Fields'
	] );

	// Show Dates Tag
	include_once( ECW_PLUGIN_PLUGIN_PATH.'modules/dynamic/show_dates.php' );
	$dynamic_tags->register_tag( 'Elementor_Show_Dates_Tag' );

    // Newsletter Tag
	include_once( ECW_PLUGIN_PLUGIN_PATH.'modules/dynamic/newsletter.php' );
	$dynamic_tags->register_tag( 'Elementor_Newsletter_Tag' );

    // Show Sponsor Tag
	include_once( ECW_PLUGIN_PLUGIN_PATH.'modules/dynamic/show_sponsor.php' );
	$dynamic_tags->register_tag( 'Elementor_Show_Sponsor_Tag' );
} );


// set up the query filter for dates - allow to not show productions that are past.
// Showing post with meta key filter in Portfolio Widget
add_action( 'elementor_pro/posts/query/show_date_filter', function( $query ) {
	// Get current meta Query
	$meta_query = $query->get( 'meta_query' );
    d($meta_query);
	// Append our meta query
    if($meta_query == "") {
        $meta_query = array();
        $query->set( 'meta_query' , $meta_query);
    }
    $meta_query[] = array(
        'key' => 'closing_night',
        'value' => date('Ymd'),
        'compare' => '>=',
        'type'    => 'NUMERIC'
    );
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
	$query->set( 'meta_query', $meta_query );
} );
