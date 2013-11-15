<?php
/*

============ appcuarium ============
									
Alfie ® Platform SDK

====== Apps outside the box.® ======

------------------------------------
Copyright © 2012-2013 Appcuarium
------------------------------------

apps@appcuarium.com
@author Sorin Gheata
@version 1.0.13
									
====================================

Alfie Weather shortcode

*/

class Alfie_WP_Shortcode
{

    static $add_shortcode_scripts;

    static function init()
    {

        add_shortcode( 'alfie_wp_weather', array( __CLASS__, 'alfie_wp_weather_shortcode' ) );
        add_action( 'init', array( __CLASS__, 'register_script' ) );
        add_action( 'wp_footer', array( __CLASS__, 'print_script' ) );

    }

    static function alfie_wp_weather_shortcode( $attributes )
    {

        self::$add_shortcode_scripts = true;

        extract( shortcode_atts( array(
            'woeid' => '866528',
            'image' => true,
            'country' => true,
            'condition' => true,
            'units' => 'c',
            'highlow' => true,
            'wind' => true,
            'humidity' => true,
            'visibility' => true,
            'sunrise' => true,
            'sunset' => true,
            'forecast' => true,
            'forecast_image' => true,
            'credits' => true
        ), $attributes ) );

        $attributes = array(
            'woeid' => $woeid,
            'alfie_wp_weather_image' => $image,
            'alfie_wp_weather_country' => $country,
            'alfie_wp_weather_condition' => $condition,
            'alfie_wp_weather_temperature' => $units,
            'alfie_wp_weather_highlow' => $highlow,
            'alfie_wp_weather_wind' => $wind,
            'alfie_wp_weather_humidity' => $humidity,
            'alfie_wp_weather_visibility' => $visibility,
            'alfie_wp_weather_sunrise' => $sunrise,
            'alfie_wp_weather_sunset' => $sunset,
            'alfie_wp_weather_forecast' => $forecast,
            'alfie_wp_weather_forecast_image' => $forecast_image,
            'alfie_wp_weather_credits' => $credits
        );

        return '<div id="woeid-' . $attributes['woeid'] . '" class="widget-container alfie-container">' . alfie_wp_weather( $attributes ) . '</div>';
    }

    static function register_script()
    {

        $protocol = 'http';

        if ( isset( $_SERVER['HTTPS'] ) ) {
            if ( strtoupper( $_SERVER['HTTPS'] ) == 'ON' ) {
                $protocol = 'https';
            }
        }

        wp_enqueue_style( 'alfie-wp-weather', ALFIE_WEATHER_URL . 'css/widget.min.css' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'alfie-wp-weatherclass', ALFIE_WEATHER_URL . 'js/alfie.weather.min.js' );
        wp_enqueue_script( 'alfie-wp-weather', ALFIE_WEATHER_URL . 'js/alfie-weather.min.js' );
        wp_localize_script( 'alfie-wp-weather', 'alfie', array( 'path' => str_replace( $protocol . '://' . $_SERVER['HTTP_HOST'], '', plugins_url() ) ) );

    }

    static function print_script()
    {
        if ( !self::$add_shortcode_scripts ) {
            return;
        }
        wp_print_scripts( 'jquery' );
        wp_print_scripts( 'alfie-wp-weatherclass', ALFIE_WEATHER_URL . 'js/alfie.weather.min.js' );
        wp_print_scripts( 'alfie-wp-weather', ALFIE_WEATHER_URL . 'js/alfie-weather.min.js' );
    }
}

Alfie_WP_Shortcode::init();