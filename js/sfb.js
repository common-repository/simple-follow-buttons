jQuery(document).ready(function() {

    // upon clicking a follow button
	jQuery('.sfb-wrap a').click(function(event){

		// don't go the the href yet
		event.preventDefault();

		// these follow options don't need to have a popup
		if (jQuery(this).data('site') == 'email' || jQuery(this).data('site') == 'print' || jQuery(this).data('site') == 'pinterest') {

			// just redirect
			 window.location.href = jQuery(this).attr("href");
		} else {

    		// prepare popup window
    		var width  = 575,
    		    height = 520,
    		    left   = (jQuery(window).width()  - width)  / 2,
    		    top    = (jQuery(window).height() - height) / 2,
    		    opts   = 'status=1' +
    		             ',width='  + width  +
    		             ',height=' + height +
    		             ',top='    + top    +
    		             ',left='   + left;

    		// open the follow url in a smaller window
    	    window.open(jQuery(this).attr("href"), 'follow', opts);
        }
	});
});
