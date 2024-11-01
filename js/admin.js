jQuery(document).ready(function() {

	// switch for checkboxes
	jQuery(".sfb-admin-wrap input:checkbox").bootstrapSwitch({
		onColor: 	'primary',
		size:		'normal'
	});

	// color picker
	jQuery('.sfb-colorpicker').colpick({
		layout:'hex',
		submit:1,
		onSubmit:function(hsb,hex,rgb,el,colid) {
			jQuery(el).val('#'+hex);
			jQuery(el).css('border-color', '#'+hex);
			jQuery(el).colpickHide();
		}
	});

	jQuery('[data-toggle="tooltip"]').tooltip();

	//------- INCLUDE LIST ----------//

	// add drag and sort functions to include table
	jQuery(function() {
		jQuery( "#sfbsort1, #sfbsort2" ).sortable({
			connectWith: ".sfbSortable"
		}).disableSelection();
	  });

	// extract and add include list to hidden field
	jQuery('#sfb_selected_buttons').val(jQuery('#sfbsort2 li').map(function() {
	// For each <li> in the list, return its inner text and let .map()
	//  build an array of those values.
	return jQuery(this).attr('id');
	}).get());

	// after a change, extract and add include list to hidden field
	jQuery('.ssbp-wrap').mouseout(function() {
		jQuery('#sfb_selected_buttons').val(jQuery('#sfbsort2 li').map(function() {
		// For each <li> in the list, return its inner text and let .map()
		//  build an array of those values.
		return jQuery(this).attr('id');
		}).get());
	});


	// when changing image sets
	jQuery('#sfb_image_set').change(function(){

		if (jQuery("#sfb_image_set").val() == "custom" ) {
			jQuery("#sfb-custom-images").fadeIn(100);
        }
        if(jQuery("#sfb_image_set").val() != "custom" ) {
			jQuery("#sfb-custom-images").fadeOut(100);
        }
	});

	// ----- IMAGE UPLOADS ------ //
	var file_frame;

    jQuery('.ssbpUpload').click(function(event){

	    event.preventDefault();

	    // set the field ID we shall add the img url to
	    var strInputID = jQuery(this).data('ssbp-input');

	    // Create the media frame.
	    file_frame = wp.media.frames.file_frame = wp.media({
	      multiple: false  // Set to true to allow multiple files to be selected
	    });

	    // When an image is selected, run a callback.
	    file_frame.on( 'select', function() {
	      	// We set multiple to false so only get one image from the uploader
	      	var attachment = file_frame.state().get('selection').first().toJSON();
			jQuery('#' + strInputID).val(attachment['url']);
	    });

	    // Finally, open the modal
	    file_frame.open();
	  });
	//---------------------------------------------------------------------------------------//
    //
    // SFB ADMIN FORM
    //
    jQuery( "#sfb-admin-form:not('.sfb-form-non-ajax')" ).on( 'submit', function(e) {

        // don't submit the form
        e.preventDefault();

        // show spinner to show save in progress
        jQuery("button.sfb-btn-save").html('<i class="fa fa-spinner fa-spin"></i>');

        // get posted data and serialise
        var sfbData = jQuery("#sfb-admin-form").serialize();

        // disable all inputs
        jQuery(':input').prop('disabled', true);
		jQuery(".sfb-admin-wrap input:checkbox").bootstrapSwitch('disabled', true);


        jQuery.post(
            jQuery( this ).prop( 'action' ),
            {
                sfbData: sfbData
            },
            function() {

				// show success
                jQuery('button.sfb-btn-save-success').fadeIn(100).delay(2500).fadeOut(200);

	            // re-enable inputs and reset save button
	            jQuery(':input').prop('disabled', false);
				jQuery(".sfb-admin-wrap input:checkbox").bootstrapSwitch('disabled', false);
                jQuery("button.sfb-btn-save").html('<i class="fa fa-floppy-o"></i>');
            }
        ); // end post
    } ); // end form submit

});
