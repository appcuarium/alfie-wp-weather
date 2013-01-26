<?php 
/*

============ appcuarium ============
									
Alfie ® Platform JS SDK

====== Apps outside the box.® ======

------------------------------------
Copyright © 2012-2013 Appcuarium
------------------------------------

apps@appcuarium.com
@author Sorin Gheata
@version 1.0
									
====================================

Alfie Weather JSON helper

*/
header('Content-type: application/json');

// Load WP classes so we can translate the strings usin WordPress native double underscore function
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );

// Get the locale value from the AJAX call
$locale = $_GET['locale'];
switch ( $locale ) {
		
		case 'en_US':
        $locale = 'en';
        break;
        
        case 'es_ES':
        $locale = 'es';
        break;
        
        case 'ro_RO':
        $locale = 'ro';
        break;


}
// Load the WPML global object
global $sitepress;

//Change language to call language
$sitepress->switch_lang( $locale, true );

// Load textomain locally
load_plugin_textdomain( 'alfie_wp_weather', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

// Create date to append to the API call URL so it caches for an hour
$random = date( 'Ymdh' );

// Get the location
$woeid = $_GET['woeid'];

// Get the temperature unit
$u = $_GET['unit'];

// Properly encode the query to the Yahoo! database
$q = rawurlencode( "select * from weather.forecast where woeid in('$woeid') and u='$u'" );

// Build the query URL
$api = "http://query.yahooapis.com/v1/public/yql?q=" . $q . "&rnd=" . $random . "&format=json";

// Get the JSON encoded response from Yahoo! API
$json = file_get_contents( $api, 0, null, null );

// Decode the response so we can translate the condition codes and week days
$decoded = json_decode( $json );

// Make the variable base
$object = $decoded->query->results->channel;

// Function that translates the names of the week days returned by Yahoo!
function translate_day( $dayname ) {
	
	switch ( $dayname ) {
		
		case 'Sun':
        $dayname = __('Sunday', 'alfie_wp_weather');
        break;
        
        case 'Mon':
        $dayname = __('Monday', 'alfie_wp_weather');
        break;
        
        case 'Tue':
        $dayname = __('Tuesday', 'alfie_wp_weather');
        break;
        
        case 'Wed':
        $dayname = __('Wednesday', 'alfie_wp_weather');
        break;
        
        case 'Thu':
        $dayname = __('Thursday', 'alfie_wp_weather');
        break;
        
        case 'Fri':
        $dayname = __('Friday', 'alfie_wp_weather');
        break;
        
        case 'Sat':
        $dayname = __('Saturday', 'alfie_wp_weather');
        break;
        
	}
	
	return $dayname;
}

// Function to translate the returned condition names
function translate_condition( $condition ) {
	
	// Condition codes are integers
	switch ( $condition ) {
			
		case 0:
        $condition = __('Tornado','alfie_wp_weather');
        break;
        	
        case 1:
        $condition = __('Tropical Storm','alfie_wp_weather');
        break;
        	
        case 2:
        $condition = __('Hurricane','alfie_wp_weather');
        break;
        	
        case 3:
        $condition = __('Severe Thunderstorms','alfie_wp_weather');
        break;
        	
        case 4:
        $condition = __('Thunderstorms','alfie_wp_weather');
        break;
        	
        case 5:
        $condition = __('Mixed Rain and Snow','alfie_wp_weather');
        break;
        	
        case 6:
        $condition = __('Mixed Rain and Sleet','alfie_wp_weather');
        break;
        	
        case 7:
        $condition = __('Mixed Snow and Sleet','alfie_wp_weather');
        break;
        	
        case 8:
        $condition = __('Freezing Drizzle','alfie_wp_weather');
        break;
        	
        case 9:
        $condition = __('Drizzle','alfie_wp_weather');
        break;
        	
        case 10:
        $condition = __('Freezing Rain','alfie_wp_weather');
        break;
        	
        case 11:
        $condition = __('Showers','alfie_wp_weather');
        break;
        	
        case 12:
        $condition = __('Showers','alfie_wp_weather');
        break;
        	
        case 13:
        $condition = __('Snow Flurries','alfie_wp_weather');
        break;
        	
        case 14:
        $condition = __('Light Snow Showers','alfie_wp_weather');
        break;
        	
        case 15:
        $condition = __('Blowing Snow','alfie_wp_weather');
        break;
        	
        case 16:
        $condition = __('Snow','alfie_wp_weather');
        break;
        	
        case 17:
        $condition = __('Hail','alfie_wp_weather');
        break;
        	
        case 18:
        $condition = __('Sleet','alfie_wp_weather');
        break;
        	
        case 19:
        $condition = __('Dust','alfie_wp_weather');
        break;
        	
        case 20:
        $condition = __('Foggy','alfie_wp_weather');
        break;
        	
        case 21:
        $condition = __('Haze','alfie_wp_weather');
        break;
        	
        case 22:
        $condition = __('Smoky','alfie_wp_weather');
        break;
        	
        case 23:
        $condition = __('Blustery','alfie_wp_weather');
        break;
        	
        case 24:
        $condition = __('Windy','alfie_wp_weather');
        break;
        	
        case 25:
        $condition = __('Cold','alfie_wp_weather');
        break;
        	
        case 26:
        $condition = __('Cloudy','alfie_wp_weather');
        break;
        	
        case 27:
        $condition = __('Mostly Cloudy','alfie_wp_weather');
        break;
        	
        case 28:
        $condition = __('Mostly Cloudy','alfie_wp_weather');
        break;
        	
        case 29:
        $condition = __('Partly Cloudy','alfie_wp_weather');
        break;
        	
        case 30:
        $condition = __('Partly Cloudy','alfie_wp_weather');
        break;
        	
        case 31:
        $condition = __('Clear','alfie_wp_weather');
        break;
        	
        case 32:
        $condition = __('Sunny','alfie_wp_weather');
        break;
        	
        case 33:
        $condition = __('Fair','alfie_wp_weather');
        break;
        	
        case 34:
        $condition = __('Fair','alfie_wp_weather');
        break;
        	
        case 35:
        $condition = __('Mixed Rain and Hail','alfie_wp_weather');
        break;
        	
        case 36:
        $condition = __('Hot','alfie_wp_weather');
        break;
        	
        case 37:
        $condition = __('Isolated Thunderstorms','alfie_wp_weather');
        break;
        	
        case 38:
        $condition = __('Scattered Thunderstorms','alfie_wp_weather');
        break;
        	
        case 39:
        $condition = __('Scattered Thunderstorms','alfie_wp_weather');
        break;
        	
        case 40:
        $condition = __('Scattered Showers','alfie_wp_weather');
        break;
        	
        case 41:
        $condition = __('Heavy Snow','alfie_wp_weather');
        break;
        	
        case 42:
        $condition = __('Scattered Snow Showers','alfie_wp_weather');
        break;
        	
        case 43:
        $condition = __('Heavy Snow','alfie_wp_weather');
        break;
        	
        case 44:
        $condition = __('Partly Cloudy','alfie_wp_weather');
        break;
        	
        case 45:
        $condition = __('Thundershowers','alfie_wp_weather');
        break;
        	
        case 46:
        $condition = __('Snow Showers','alfie_wp_weather');
        break;
        	
        case 47:
        $condition = __('Isolated Thundershowers','alfie_wp_weather');
        break;
        	
        case 3200:
        $condition = __('Not Available','alfie_wp_weather');
        break;
        
        
    }
    
    return $condition;
}        
        // Rebuild the array, including now the localized values
        $result = array('data' => array(
        	'title' => $object->title,
        	'link' => $object->link,
        	'description' => $object->description,
        	'language' => $object->language,
        	'lastBuildDate' => $object->lastBuildDate,
        	'ttl' => $object->ttl,
        	'location' => array(
        		'city' => $object->location->city,
        		'country' => $object->location->country
        	),
        	'units' => array(
        		'distance' => $object->units->distance,
        		'pressure' => $object->units->pressure,
        		'speed' => $object->units->speed,
        		'temperature' => $object->units->temperature
        	),
        	'wind' => array(
        		'chill' => $object->wind->chill,
        		'direction' => $object->wind->direction,
        		'speed' => $object->wind->speed
        	),
        	'atmosphere' => array(
        		'humidity' => $object->atmosphere->humidity,
        		'pressure' => $object->atmosphere->pressure,
        		'rising' => $object->atmosphere->rising,
        		'visibility' => $object->atmosphere->visibility
        	),
        	'astronomy' => array(
        		'sunrise' => $object->astronomy->sunrise,
        		'sunset' => $object->astronomy->sunset
        	),
        	'image' => array(
        		'title' => $object->image->title,
        		'width' => $object->image->width,
        		'height' => $object->image->height,
        		'link' => $object->image->link,
        		'url' => $object->image->url
        	),
        	'item' => array(
        		'title' => $object->item->title,
        		'lat' => $object->item->lat,
        		'long' => $object->item->long,
        		'link' => $object->item->link,
        		'pubDate' => $object->item->pubDate,
        		'condition' => array (
        			'code' => $object->item->condition->code,
                    'date' => $object->item->condition->date,
                    'temp' => $object->item->condition->temp,
                    'text' => translate_condition($object->item->condition->code)
        		),
        		'description' => $object->item->description,
        		'forecast' => array(
        			'today' => array(
        				'code' => $object->item->forecast[0]->code,
                        'date' => $object->item->forecast[0]->date,
                        'day' => translate_day( $object->item->forecast[0]->day ),
                        'high' => $object->item->forecast[0]->high,
                        'low' => $object->item->forecast[0]->low,
                        'text' => translate_condition($object->item->forecast[0]->code)
        			),
        			'tomorrow' => array(
        				'code' => $object->item->forecast[1]->code,
                        'date' => $object->item->forecast[1]->date,
                        'day' => translate_day( $object->item->forecast[1]->day ),
                        'high' => $object->item->forecast[1]->high,
                        'low' => $object->item->forecast[1]->low,
                        'text' => translate_condition( $object->item->forecast[1]->code )
        			),
        		),
        		'guid' => array(
        			'isPermaLink' => $object->item->guid->isPermaLink,
                    'content' => $object->item->guid->content
        		)
        	)
        ));
        // Encode the array
        echo ( json_encode( $result ) );
        
        // Done.

?>