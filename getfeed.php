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
$random = date( 'Ymdh' );
$woeid = $_GET['woeid'];
$u = $_GET['unit'];
$q = rawurlencode( "select * from weather.forecast where woeid in('$woeid') and u='$u'" );
$api = "http://query.yahooapis.com/v1/public/yql?q=" . $q . "&rnd=" . $random . "&format=json";
$json = file_get_contents( $api, 0, null, null );

echo $json;

?>