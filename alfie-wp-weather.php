<?php
/**

	Alfie WP Weather Widget 1.0

*/

function alfie_wp_weather( $options ) {
// Show the widget items as selected in the admin
?>
<div id="dummy"></div>
<script id="widget-template" type="alfie/appcuarium">
			<div class="alfie-wp-weather-object {{daynight}}" style="background-image: url({{image_bg}}{{daynight}}.png); background-repeat: no-repeat;">
			<div class="weather-main-info">
				<div class="alfie-wp-weather-item alfie-city">{{city}}</div>
				<?php if ( $options['alfie_wp_weather_country'] ) { ?>
				<div class="alfie-wp-weather-item alfie-country">{{country}}</div>
				<?php } ?>
				<div class="alfie-wp-weather-item alfie-temperature"><span>{{currentTemp}}</span>&deg;</div>
				<?php if ( $options['alfie_wp_weather_condition'] ) { ?>
				<div class="alfie-wp-weather-item alfie-description">{{condition}}</div>
				<?php } ?>
				<?php if ( $options['alfie_wp_weather_highlow'] ) { ?>
				<div class="alfie-wp-weather-item alfie-range"><?php echo __('High','alfie_wp_weather');?>:&nbsp;{{high}}&deg;&nbsp;<?php echo __('Low','alfie_wp_weather');?>:&nbsp;{{low}}&deg;</div>
				<?php } ?>
				<?php if ( $options['alfie_wp_weather_wind'] ) { ?>
				<div class="alfie-wp-weather-item alfie-wind"><?php echo __('Wind','alfie_wp_weather');?>:&nbsp;{{wind_direction}} {{wind}} {{speed_unit}}</div>
				<?php } ?>
				<?php if ( $options['alfie_wp_weather_humidity'] ) { ?>
				<div class="alfie-wp-weather-item alfie-humidity"><?php echo __('Humidity','alfie_wp_weather');?>:&nbsp;{{humidity}}&#37;</div>
				<?php } ?>
				<?php if ( $options['alfie_wp_weather_visibility'] ) { ?>
				<div class="alfie-wp-weather-item alfie-visibility"><?php echo __('Visibility','alfie_wp_weather');?>:&nbsp;{{visibility}}</div>
				<?php } ?>
				<?php if ( $options['alfie_wp_weather_sunrise'] ) { ?>
				<div class="alfie-wp-weather-item alfie-sunrise"><?php echo __('Sunrise','alfie_wp_weather');?>:&nbsp;{{sunrise}}</div>
				<?php } ?>
				<?php if ( $options['alfie_wp_weather_sunset'] ) { ?>
				<div class="alfie-wp-weather-item alfie-sunset"><?php echo __('Sunset','alfie_wp_weather');?>:&nbsp;{{sunset}}</div>
				<?php } ?>
				</div>
				<?php if ( $options['alfie_wp_weather_forecast'] ) { ?>
				<div class="alfie-wp-weather-forecast">
					<div class="alfie-wp-weather-forecast-item" style="background-image: url(http://l.yimg.com/a/i/us/nws/weather/gr/{{forecast_one_code}}s.png); background-repeat: no-repeat;">
						<div class="alfie-wp-weather-forecast-day">{{day_one}}</div>
						<div class="alfie-wp-weather-forecast-highlow"><?php echo __('High','alfie_wp_weather');?>:&nbsp;<span>{{forecast_one_high}}&deg;</span></div>
						<div class="alfie-wp-weather-forecast-highlow"><?php echo __('Low','alfie_wp_weather');?>:&nbsp;{{forecast_one_low}}&deg;</div>
					</div>
			
					<div class="alfie-wp-weather-forecast-item" style="background-image: url(http://l.yimg.com/a/i/us/nws/weather/gr/{{forecast_two_code}}s.png); background-repeat: no-repeat;">
						<div class="alfie-wp-weather-forecast-day">{{day_two}}</div>
						<div class="alfie-wp-weather-forecast-highlow"><?php echo __('High','alfie_wp_weather');?>:&nbsp;<span>{{forecast_two_high}}&deg;</span></div>
						<div class="alfie-wp-weather-forecast-highlow"><?php echo __('Low','alfie_wp_weather');?>:&nbsp;{{forecast_two_low}}&deg;</div>
					</div>
				</div>
				<?php } ?>
				<div class="alfie-wp-weather-footer">
					<ul>
						<li class="left"><img title="{{yahoo_logo_title}}" src="{{yahoo_logo}}" width="80"></li>
						<li class="right">powered by <a href="http://www.appcuarium.com" target="_blank"><strong>appcuarium</strong></a></li>
					</ul>
				</div>
				
			</div>
		</script>
<script>
jQuery(function () {

		var $me = jQuery('body');
		$me.alfie({
		action: {
			get_weather: {
				params: {
					woeid: <?php echo $options['woeid']; ?>,
					unit: '<?php echo $options['alfie_wp_weather_temperature']; ?>',
					image: <?php echo $options['alfie_wp_weather_image']; ?>,
					country: <?php echo $options['alfie_wp_weather_country']; ?>,
					highlow: <?php echo $options['alfie_wp_weather_highlow']; ?>,
					wind: <?php echo $options['alfie_wp_weather_wind']; ?>,
					humidity: <?php echo $options['alfie_wp_weather_humidity']; ?>,
					visibility: <?php echo $options['alfie_wp_weather_visibility']; ?>,
					sunrise: <?php echo $options['alfie_wp_weather_sunrise']; ?>,
					sunset: <?php echo $options['alfie_wp_weather_sunset']; ?>,
					forecast: <?php echo $options['alfie_wp_weather_forecast']; ?>,
					locale: '<?php echo get_locale();?>'
				}
			}
		}
	});
});
</script>
<?php
}

class alfie_wp_weather_widget extends WP_Widget {
	
	function __construct() {
				
		$widget_options = array( 'classname' => 'alfie_wp_weather', 'description' => __( 'Alfie WP Weather widget.', 'alfie_wp_weather' ) );
		
		$this->WP_Widget( 'alfie-wp-weather', 'Alfie WP Weather', $widget_options );
		
		if ( is_active_widget( false, false, $this->id_base ) ) {
			
			wp_enqueue_style( 'alfie-wp-weather', ALFIE_WEATHER_URL . 'css/widget.min.css' );	
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'alfie-wp-weatherclass', ALFIE_WEATHER_URL . 'js/alfie.weather.min.js' );
			wp_enqueue_script( 'alfie-wp-weather', ALFIE_WEATHER_URL . 'js/alfie-weather.min.js' );	
			
		}
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$args = array(
		
			'woeid'				=> intval( $instance['woeid'] ),
			'alfie_wp_weather_image'		=> !empty( $instance['alfie_wp_weather_image'] ) ? 1 : 0,
			'alfie_wp_weather_country'		=> !empty( $instance['alfie_wp_weather_country'] ) ? 1 : 0,
			'alfie_wp_weather_condition'		=> !empty( $instance['alfie_wp_weather_condition'] ) ? 1 : 0,
			'alfie_wp_weather_temperature'		=> $instance['alfie_wp_weather_temperature'],
			'alfie_wp_weather_highlow'		=> !empty( $instance['alfie_wp_weather_highlow'] ) ? 1 : 0,
			'alfie_wp_weather_wind'		=> !empty( $instance['alfie_wp_weather_wind'] ) ? 1 : 0,
			'alfie_wp_weather_humidity'		=> !empty( $instance['alfie_wp_weather_humidity'] ) ? 1 : 0,
			'alfie_wp_weather_visibility'		=> !empty( $instance['alfie_wp_weather_visibility'] ) ? 1 : 0,
			'alfie_wp_weather_sunrise'		=> !empty( $instance['alfie_wp_weather_sunrise'] ) ? 1 : 0,
			'alfie_wp_weather_sunset'		=> !empty( $instance['alfie_wp_weather_sunset'] ) ? 1 : 0,
			'alfie_wp_weather_forecast'		=> !empty( $instance['alfie_wp_weather_forecast'] ) ? 1 : 0
		
		); 
		
		echo $before_widget;
		
		if ( !empty( $instance['title'] ) ) {
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
		}
		echo '<li class="widget-container alfie-container">';
		alfie_wp_weather( $args );
		echo '</li>';
		echo $after_widget;
		
	}

	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;

		$instance = $new_instance;
		$instance['woeid'] = strip_tags( $new_instance['woeid'] );
		$instance['alfie_wp_weather_image'] = ( isset( $new_instance['alfie_wp_weather_image'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_country'] = ( isset( $new_instance['alfie_wp_weather_country'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_condition'] = ( isset( $new_instance['alfie_wp_weather_condition'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_temperature'] = strip_tags( $new_instance['alfie_wp_weather_temperature'] );
		$instance['alfie_wp_weather_highlow'] = ( isset( $new_instance['alfie_wp_weather_highlow'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_wind'] = ( isset( $new_instance['alfie_wp_weather_wind'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_humidity'] = ( isset( $new_instance['alfie_wp_weather_humidity'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_visibility'] = ( isset( $new_instance['alfie_wp_weather_visibility'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_sunrise'] = ( isset( $new_instance['alfie_wp_weather_sunrise'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_sunset'] = ( isset( $new_instance['alfie_wp_weather_sunset'] ) ? 1 : 0 );
		$instance['alfie_wp_weather_forecast'] = ( isset( $new_instance['alfie_wp_weather_forecast'] ) ? 1 : 0 );
		return $instance;
	}	

	function form( $instance ) {
		wp_enqueue_style( 'alfie_weatheroptions', ALFIE_WEATHER_URL . 'css/admin.min.css', false, 0.7, 'screen' );	
		wp_enqueue_script( 'alfie-wp-weatherclass_admin', ALFIE_WEATHER_URL . 'js/alfie.weather.min.js' );
		wp_enqueue_script( 'alfie-wp-weather_admin', ALFIE_WEATHER_URL . 'js/alfie-weather.min.js' );	
			
		$defaults = array(
			'title' => __( 'Local Weather', 'alfie_wp_weather' ),
			'woeid' => '769293',
			'alfie_wp_weather_image' => true,
			'alfie_wp_weather_country' => true,
			'alfie_wp_weather_condition' => true,
			'alfie_wp_weather_temperature' => 'c',
			'alfie_wp_weather_highlow' => true,
			'alfie_wp_weather_wind' => true,
			'alfie_wp_weather_humidity' => true,
			'alfie_wp_weather_visibility' => true,
			'alfie_wp_weather_sunrise' => true,
			'alfie_wp_weather_sunset' => true,
			'alfie_wp_weather_forecast' => true
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		$temperature = strip_tags($instance['alfie_wp_weather_temperature']);
		$temperature_option = array( 'c' => __( 'Celsius', 'alfie_wp_weather' ), 'f' => __( 'Fahreinheit', 'alfie_wp_weather' ) );
	?>
		<script id="weather-template" type="alfie/appcuarium">
			<li rel="{{woeid}}" class="item city-woeid">
				<a>{{location}} - {{country}}</span>
			</li>
		</script>
		<div class="widget-controls">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'alfie_wp_weather' ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'woeid' ); ?>"><?php _e( 'WOEID:', 'alfie_wp_weather' ); ?></label>
				<input type="text" class="widefat alfie-woeid" id="<?php echo $this->get_field_id( 'woeid' ); ?>" name="<?php echo $this->get_field_name( 'woeid' ); ?>" value="<?php echo esc_attr( $instance['woeid'] ); ?>" />
			</p>
			
			<div id="location-search">
				<div id="location-input">
					<label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e( 'Search for a location:', 'alfie_wp_weather' ); ?></label>
					<input autocomplete="off" class="widefat" type="text" id="search-location" name="search-location" />
				</div>
					<a id="search_woeid" class="button button-primary fullwidth aligncenter mb20"><?php _e( 'Click to search location', 'alfie_wp_weather' ); ?></a>
					<div id="weatherList"></div>
					<div id="cities"></div>
					
			</div>
			<br />
			<div class="clear"></div>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_temperature' ); ?>"><?php _e('Temperature', 'alfie_wp_weather' ) ?></label> 
				<select class="smallfat" id="<?php echo $this->get_field_id( 'alfie_wp_weather_temperature' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_temperature' ); ?>">
					<?php foreach ( $temperature_option as $dataype => $option_label ) { ?>
						<option value="<?php echo esc_attr( $dataype ); ?>" <?php selected( $temperature, $dataype ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>			
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_image' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_image'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_image' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_image' ); ?>" /> <?php _e( 'Show image?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_country' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_country'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_country' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_country' ); ?>" /> <?php _e( 'Show country?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_condition' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_condition'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_condition' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_condition' ); ?>" /> <?php _e( 'Show condition?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_highlow' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_highlow'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_highlow' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_highlow' ); ?>" /> <?php _e( 'Show High/Low info?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_wind' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_wind'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_wind' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_wind' ); ?>" /> <?php _e( 'Show wind info?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_humidity' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_humidity'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_humidity' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_humidity' ); ?>" /> <?php _e( 'Show humidity info?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_visibility' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_visibility'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_visibility' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_visibility' ); ?>" /> <?php _e( 'Show visibility info?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_sunrise' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_sunrise'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_sunrise' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_sunrise' ); ?>" /> <?php _e( 'Show sunrise info?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_sunset' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_sunset'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_sunset' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_sunset' ); ?>" /> <?php _e( 'Show sunset info?', 'alfie_wp_weather' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'alfie_wp_weather_forecast' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $instance['alfie_wp_weather_forecast'], true ); ?> id="<?php echo $this->get_field_id( 'alfie_wp_weather_forecast' ); ?>" name="<?php echo $this->get_field_name( 'alfie_wp_weather_forecast' ); ?>" /> <?php _e( 'Show forecast?', 'alfie_wp_weather' ); ?></label>
			</p>
		</div>
		<div class="clear"></div>
	<?php
	}
}
?>