<?php
/*

Plugin Name: Alfie WordPress Weather Plugin
Plugin URI: http://www.appcuarium.com
Description: Add weather forecasts to your WP website.
Version: 1.0.1
Author: Appcuarium
Author URI: http://www.appcuarium.com
Text Domain: alfie_wp_weather
Domain Path: /lang
License: GPL2

Copyright 2012-2013 Appcuarium | Apps outside the box.®  ( email : apps@appcuarium.com )

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Initialize the plugin and its features. 

*/
$plugin_desc = __('Add weather forecasts to your WP website.','alfie_wp_weather');
function load_alfie_wp_weather() {

	define( 'ALFIE_WEATHER_DIR', plugin_dir_path( __FILE__ ) );
	define( 'ALFIE_WEATHER_URL', plugin_dir_url( __FILE__ ) );
	
	// Make plugin translatable
	$domain = 'alfie_wp_weather';
	$locale = apply_filters('plugin_locale', get_locale(), $domain);
	load_textdomain('alfie_wp_weather', dirname( plugin_basename( __FILE__ ) ) . '/lang/'.$domain.'-'.get_locale().'.mo');
    load_plugin_textdomain( 'alfie_wp_weather', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	
	// Load the plugin widget
	add_action( 'widgets_init', 'alfie_wp_weather_widget' );
}

// Load the plugin
add_action( 'plugins_loaded', 'load_alfie_wp_weather' );

// Register the widget
function alfie_wp_weather_widget() {

	require_once( trailingslashit( ALFIE_WEATHER_DIR ) . 'alfie-wp-weather.php' );	
	register_widget( 'alfie_wp_weather_widget' );

}

// Done.

?>