/*

 ============ appcuarium ============

 Alfie ® Platform JS SDK

 ====== Apps outside the box.® ======

 ------------------------------------
 Copyright © 2012-2013 Appcuarium
 ------------------------------------

 apps@appcuarium.com
 @author Sorin Gheata
 @version 1.0.15

 ====================================

 Alfie Weather Javascript Loader

 */

(function ($, window, document, undefined) {

    var $body = $('body');

    $body.on('click', '.city-woeid',function (e) {
        var woeid = $(this).attr('rel');
        $('#widgets-right .alfie-woeid').val(woeid);
        $('#widgets-right #cities').empty();
        $('#widgets-right #location-input').hide();
        $('#widgets-right #search_woeid').show();
        $('#widgets-right #search-location').val('');
        e.preventDefault();
    }).on('click', '#search_woeid', function (e) {

            var $me = $(this);
            $me.hide();
            $('#widgets-right #location-input').show();
            $me.alfie({
                action: {
                    searchDelayed: function (response) {
                    }
                }
            });

            e.preventDefault();
        });

})(jQuery, window, document);