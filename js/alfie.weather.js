/*

============ appcuarium ============
									
Alfie ® Platform JS SDK

====== Apps outside the box.® ======

------------------------------------
Copyright © 2012 Appcuarium
------------------------------------

apps@appcuarium.com
@author Sorin Gheata
@version 1.0
									
====================================

Alfie Weather plugin 

*/

// Create wrapper for non-supporting browsers
if ( typeof Object.create !== 'function' ) {
    
    Object.create = function ( obj ) {
        function F() {};
        F.prototype = obj;
        return new F();
    };

}

( function ( $, window, document, undefined ) {
    
    var Alfie = {
        init: function ( options, elem ) {

            var me = this;
            me.elem = elem;
            me.$elem = $( elem );
            me.options = $.extend( {}, $.fn.alfie.options, options );
            me.query = '';
            me.searchInput = $( '#widgets-right #search-location' );
            me.template = $.trim( $('#weather-template' ).html() );
            me.route();

        },

        // Receive scope and action and route input based on values
        route: function () {
            var me = this;
            action = me.options.action;
            return me.executeQuery( action );
        
        },
		
        // Execute called function
        executeQuery: function ( action ) {
            var me = this;
               	
		if ( typeof action === 'string' ) {
		
			var array = action.split(/[ ,]+/),
				count = array.length;
                       
			return $.when( me[array].call( me ) ).done( function( response ) {
		
			});
		}
		
		else if ( typeof action === 'object' ) {
			
			$.each( action, function( key, value ) {   
					
					if( value.next ) {
								
						next = value.next;			
						
						$.when( me[ key ].call( me, value ) ).pipe( function( data ) {
      			      
      							return me[ next ].call( me, data );
      			
    							}).then( function( data ) {
									
									console.log( key + ' Resolved -> Chained done for: ' + data );
					
				}, function( message ) {
				
					console.log( key + ' Rejected: Reason -> ' +  message ) ;
					
				});

			}
			
			else {
			
				return me[ key ].call( me, value );
			
				}
										            				
            });
		}
        },
		
		searchDelayed: function( term ) {
			var me = this;
			me.searchInput.on( 'keyup', me.search );
		},

		search: function() {
			var self = Alfie,
				input = this,
				dfd = $.Deferred();

			clearTimeout( self.timer );

			self.timer = ( input.value.length >= 3 ) && setTimeout(function() {

				self.query = input.value;
				now = new Date();

			var query = 'select * from geo.places where text="'+ self.query +'"',
				api = 'http://query.yahooapis.com/v1/public/yql?q='+ encodeURIComponent(query) +'&rnd='+ now.getFullYear() + now.getMonth() + now.getDay() + now.getHours() +'&format=json&callback=?';
				
				$.when( self.fetch( api, 'json' ) ).then( function( response ) {
					$.when( self.build ( response ) ).done(function(resp){
						$('#widgets-right #cities').html( resp );
					});
					dfd.resolve();
				});
				
			}, 400);
			
			return dfd.promise();
		},
		
		get_weather: function( params ) {
			var me = Alfie;
			
			$.when( me.fetch('/wp-content/plugins/alfie-wp-weather/getfeed.php', 'json', params.params )).then(function( response ) {
				$.when(me.build_weather_widget(response)).done(function(res){
					$('#dummy').append( res );
				});
			});
		},
		getTimeAsDate: function(t) {
		
				d = new Date();
				r = new Date(d.toDateString() +' '+ t);

				return r;
		},
		
		build_weather_widget: function( results ) {
			   	var me = this,
            	dfd = $.Deferred(),
            	widgetTemplate = $.trim( $('#widget-template' ).html() ),
            	widgetEnvelope = $( '<ul />', {
                	class: 'loaded'
                });
                
            var obj = $.map( results, function ( result, i ) {

	            // Day or night?
				wpd = result.item.pubDate;
				n = wpd.indexOf(":");
				tpb = me.getTimeAsDate(wpd.substr(n-2,8));
				tsr = me.getTimeAsDate(result.astronomy.sunrise);
				tss = me.getTimeAsDate(result.astronomy.sunset);

				// Get night or day
				if (tpb>tsr && tpb<tss) { daynight = 'day'; } else { daynight = 'night'; }

            	var wd = result.wind.direction;
				if (wd>=348.75&&wd<=360){wd="N"};if(wd>=0&&wd<11.25){wd="N"};if(wd>=11.25&&wd<33.75){wd="NNE"};if(wd>=33.75&&wd<56.25){wd="NE"};if(wd>=56.25&&wd<78.75){wd="ENE"};if(wd>=78.75&&wd<101.25){wd="E"};if(wd>=101.25&&wd<123.75){wd="ESE"};if(wd>=123.75&&wd<146.25){wd="SE"};if(wd>=146.25&&wd<168.75){wd="SSE"};if(wd>=168.75&&wd<191.25){wd="S"};if(wd>=191.25 && wd<213.75){wd="SSW"};if(wd>=213.75&&wd<236.25){wd="SW"};if(wd>=236.25&&wd<258.75){wd="WSW"};if(wd>=258.75 && wd<281.25){wd="W"};if(wd>=281.25&&wd<303.75){wd="WNW"};if(wd>=303.75&&wd<326.25){wd="NW"};if(wd>=326.25&&wd<348.75){wd="NNW"};
            	
            	var widgetHTML = widgetTemplate
                	.replace(/{{city}}/ig, result.location.city)
                	.replace(/{{country}}/ig, result.location.country)
                	.replace(/{{currentTemp}}/ig, result.item.condition.temp)
                	.replace(/{{condition_code}}/ig, result.item.condition.code)
                	.replace(/{{daynight}}/ig, daynight.substring(0,1))
                	.replace(/{{condition}}/ig, result.item.condition.text)
                	.replace(/{{high}}/ig, result.item.forecast.today.high)
                	.replace(/{{low}}/ig, result.item.forecast.today.low)
                	.replace(/{{wind}}/ig, result.wind.speed)
                	.replace(/{{wind_direction}}/ig, wd)
                	.replace(/{{speed_unit}}/ig, result.units.speed)
                	.replace(/{{distance_unit}}/ig, result.units.distance)
                	.replace(/{{pressure_unit}}/ig, result.units.pressure)
                	.replace(/{{temperature_unit}}/ig, result.units.speed)
                	.replace(/{{humidity}}/ig, result.atmosphere.humidity)
                	.replace(/{{visibility}}/ig, result.atmosphere.visibility)
                	.replace(/{{sunrise}}/ig, result.astronomy.sunrise)
                	.replace(/{{sunset}}/ig, result.astronomy.sunset)
                	.replace(/{{day_one}}/ig, result.item.forecast.today.day)
                	.replace(/{{day_two}}/ig, result.item.forecast.tomorrow.day)
                	.replace(/{{forecast_one_high}}/ig, result.item.forecast.today.high)
                	.replace(/{{forecast_one_low}}/ig, result.item.forecast.today.low)
                	.replace(/{{forecast_two_high}}/ig, result.item.forecast.tomorrow.high)
                	.replace(/{{forecast_two_low}}/ig, result.item.forecast.tomorrow.low)
                	.replace(/{{forecast_one_code}}/ig, result.item.forecast.today.code)
                	.replace(/{{forecast_two_code}}/ig, result.item.forecast.tomorrow.code)
                	.replace(/{{yahoo_logo}}/ig, result.image.url);
				
               	var results = $( '.alfie-container' ).html( widgetHTML )[0];
               		dfd.resolve( results ); 
                
            });
            
            return dfd.promise();
		},
        fetch: function ( url, encoding, params ) {

        	var me = this,  	        		
        		ajaxEncoding = url.encoding || encoding,
        		ajaxUrl = url.url || url,
        		ajaxParams = url.params || params;
            
            return $.ajax({
                
                url: ajaxUrl,
                async: false,
                cache: false,
                data: ajaxParams,
                dataType: ajaxEncoding
            
            });
        },

        // Build the query object
        build: function ( results ) {
        	
            var me = this,
            	dfd = $.Deferred(),
            	template = $.trim( $('#weather-template' ).html() ),
            	entryEnvelope = $( '<ul />', {
                	class: 'loaded'
                });
            
            var objects = $.map( results.query.results, function ( result, i ) {
            	$.each(result, function( index, value ){
	            	var entryHTML = template
                	.replace(/{{woeid}}/ig, value.woeid)
                	.replace(/{{location}}/ig, value.name)
                	.replace(/{{country}}/ig, value.country.content);

               var results = $( entryEnvelope ).append( entryHTML )[0];
               		dfd.resolve( results ); 
            	});
            	
            });
            
           
            return dfd.promise();
        }
    };

    $.fn.alfie = function ( options ) {
        var alfie_framework = Object.create( Alfie );
        if ( alfie_framework[options] ) {
            return alfie_framework[options].apply( this, Array.prototype.slice.call( arguments, 1 ) );
        } else if ( typeof options === 'object' || !options ) {
            return this.each( function () {

                alfie_framework.init( options, this );

                $.data( this, 'alfie', alfie_framework );
            });
        }
    };

    $.fn.alfie.options = {};
		
})(jQuery, window, document);