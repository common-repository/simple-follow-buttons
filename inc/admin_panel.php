<?php

function sfb_admin_header()
{
	// open wrap
	$htmlHeader = '<div class="sfb-admin-wrap">';

	// navbar/header
	$htmlHeader .= '<nav class="navbar navbar-default">
					  <div class="container-fluid">
					    <div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					      <a class="navbar-brand" href="https://simplefollowbuttons.com"><img src="'.plugins_url().'/simple-follow-buttons/images/simple_follow_buttons_logo.png" alt="Simple Follow Buttons" class="sfb-logo-img" /></a>
					    </div>

					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					      <ul class="nav navbar-nav navbar-right">
					        <li><a data-toggle="modal" data-target="#ssbSupportModal" href="#">Support</a></li>
					        <li><a class="btn btn-primary sfb-navlink-blue" href="https://simplefollowbuttons.com/plus/?utm_source=standard&utm_medium=plugin_ad&utm_campaign=product&utm_content=navlink" target="_blank">Plus <i class="fa fa-plus"></i></a></li>
					      </ul>
					    </div>
					  </div>
					</nav>';

    $htmlHeader.= '<div class="modal fade" id="ssbSupportModal" tabindex="-1" role="dialog" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						        <h4 class="modal-title">Simple Share Buttons Support</h4>
						      </div>
						      <div class="modal-body">
						        <p>Please note that the this plugin relies mostly on WordPress community support from other  users.</p>
						        <p>If you wish to receive official support, please consider purchasing <a href="https://simplesharebuttons.com/plus/?utm_source=standard&utm_medium=plugin_ad&utm_campaign=product&utm_content=support_modal" target="_blank"><b>Simple Share Buttons Plus</b></a></p>
						        <div class="row">
    						        <div class="col-sm-6">
    						            <a href="https://wordpress.org/support/plugin/simple-follow-buttons" target="_blank"><button class="btn btn-block btn-default">Community support</button></a>
                                    </div>
                                    <div class="col-sm-6">
    						            <a href="https://simplefollowbuttons.com/plus/?utm_source=standard&utm_medium=plugin_ad&utm_campaign=product&utm_content=support_modal" target="_blank"><button class="btn btn-block btn-primary">Check out Plus</button></a>
    						        </div>
                                </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>';

		// open container - closed in footer
		$htmlHeader .= '<div class="container">';

	// return
	return $htmlHeader;
}

function sfb_admin_footer()
{
	// row
	$htmlFooter = '<footer class="row">';

		// col
		$htmlFooter .= '<div class="col-sm-12">';

			// link to show footer content
			$htmlFooter .= '<a href="https://simplefollowbuttons.com" target="_blank">Simple Follow Buttons</a> <span class="badge">'.SFB_VERSION.'</span>';

			// show more/less links
			$htmlFooter .= '<button type="button" class="sfb-btn-thank-you pull-right btn btn-primary" data-toggle="modal" data-target="#sfbFooterModal"><i class="fa fa-info"></i></button>';

			$htmlFooter.= '<div class="modal fade" id="sfbFooterModal" tabindex="-1" role="dialog" aria-labelledby="sfbFooterModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						        <h4 class="modal-title">Simple Follow Buttons</h4>
						      </div>
						      <div class="modal-body">
						        <p>Many thanks for choosing <a href="https://simplefollowbuttons.com" target="_blank">Simple Follow Buttons</a> for your follow buttons plugin, we\'re confident you won\'t be disappointed in your decision. If you require any support, please visit the <a href="https://wordpress.org/support/plugin/simple-follow-buttons" target="_blank">support forum</a>.</p>
						        <p>If you like the plugin, we\'d really appreciate it if you took a moment to <a href="https://wordpress.org/support/view/plugin-reviews/simple-follow-buttons" target="_blank">leave a review</a>, if there\'s anything missing to get 5 stars do please <a href="https://simplefollowbuttons.com/contact/" target="_blank">let us know</a>.</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>';

		// close col
		$htmlFooter .= '</div>';

	// close row
	$htmlFooter .= '</footer>';

	// close container - opened in header
	$htmlFooter .= '</div>';

	// close sfb-admin-wrap - opened in header
	$htmlFooter .= '</div>';

	// return
	return $htmlFooter;
}

function sfb_admin_panel($arrSettings) {

	// include the forms helper
	include_once 'forms.php';

	// prepare array of buttons
    $arrButtons = json_decode(get_option('sfb_buttons'), true);

	// get the font family needed
	$htmlFollowButtonsForm = '<style>'.sfb_get_font_family().'</style>';

	// if left to right
	if (is_rtl()) {
    	// move save button
    	$htmlFollowButtonsForm .= '<style>.sfb-btn-save{left: 0!important;
                                        right: auto !important;
                                        border-radius: 0 5px 5px 0;}
                                </style>';
	}

	// add header
	$htmlFollowButtonsForm .= sfb_admin_header();

	// initiate forms helper
	$ssbpForm = new ssbpForms;

	// opening form tag
	$htmlFollowButtonsForm .= $ssbpForm->open(false);

	// heading
	$htmlFollowButtonsForm .= '<h2>Follow Buttons Settings</h2>';

	// tabs
	$htmlFollowButtonsForm .= '<ul class="nav nav-tabs">
								  <li class="active"><a href="#core" data-toggle="tab">Core</a></li>
								  <li><a href="#styling" data-toggle="tab">Styling</a></li>
								  <li><a href="#advanced" data-toggle="tab">Advanced</a></li>
								  <li class="dropdown">
								    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
								      CSS <span class="caret"></span>
								    </a>
								    <ul class="dropdown-menu">
								      <li><a href="#css_additional" data-toggle="tab">Additional</a></li>
								      <li><a href="#css_custom" data-toggle="tab">Custom</a></li>
								    </ul>
								  </li>
								</ul>';
	// tab content div
	$htmlFollowButtonsForm .= '<div id="sfbTabContent" class="tab-content">';

		//======================================================================
		// 		CORE
		//======================================================================
		$htmlFollowButtonsForm .= '<div class="tab-pane fade active in" id="core">';

			// basic info
			$htmlFollowButtonsForm .= '<blockquote><p>The <b>simple</b> options you can see below are all you need to complete to get your <b>follow buttons</b> to appear on your website. Once you\'re done here, you can further customise the follow buttons via the Styling tab.</p></blockquote>';

			// COLUMN --------------------------------
			$htmlFollowButtonsForm .= '<div class="col-sm-12">';

				// locations array
				$locs = array(
					'Pages'	=> array(
						'value' => 'sfb_pages',
						'checked' => ($arrSettings['sfb_pages'] == 'Y'  ? true : false)
					),
					'Posts' => array(
						'value' => 'sfb_posts',
						'checked' => ($arrSettings['sfb_posts'] == 'Y'  ? true : false)
					),
				);
				// locations
				$opts = array(
					'form_group' 	=> false,
					'label' 		=> 'Locations',
					'tooltip'		=> 'Enable the locations you wish for follow buttons to appear',
					'value'			=> 'Y',
					'checkboxes'	=> $locs
				);
				$htmlFollowButtonsForm .= $ssbpForm->ssbp_checkboxes($opts);

				// placement
	            $opts = array(
	                'form_group'	=> false,
	                'type'       	=> 'select',
	                'name'          => 'sfb_before_or_after',
	                'label'        	=> 'Placement',
	                'tooltip'       => 'Place follow buttons before or after your content',
	                'selected'      => $arrSettings['sfb_before_or_after'],
	                'options'       => array(
	                                        'After'    => 'after',
	                                        'Before'    => 'before',
	                                        'Both'        => 'both',
	                                    ),
	            );
				$htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

	            // follow text
	            $opts = array(
	                'form_group'    => false,
	                'type'          => 'text',
	                'placeholder'	=> 'Keeping following simple...',
	                'name'          => 'sfb_follow_text',
	                'label'        	=> 'Follow Text',
	                'tooltip'       => 'Add some custom text by your follow buttons',
	                'value'         => $arrSettings['sfb_follow_text'],
	            );
				$htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

				// networks
				$htmlFollowButtonsForm .= '<label for="sfb_choices" class="control-label" data-toggle="tooltip" data-placement="right" data-original-title="Drag, drop and reorder those buttons that you wish to include">Networks</label>
											<div class="">';

					$htmlFollowButtonsForm .= '<div class="ssbp-wrap ssbp--centred ssbp--theme-4">
													<div class="ssbp-container">
														<ul id="sfbsort1" class="ssbp-list sfbSortable">';
								$htmlFollowButtonsForm .= getAvailableSFB($arrSettings['sfb_selected_buttons']);
							$htmlFollowButtonsForm .= '</ul>
													</div>
												</div>';
						$htmlFollowButtonsForm .= '<div class="well">';
						$htmlFollowButtonsForm .= '<div class="sfb-well-instruction"><i class="fa fa-download"></i> Drop icons below</div>';
						$htmlFollowButtonsForm .= '<div class="ssbp-wrap ssbp--centred ssbp--theme-4">
													<div class="ssbp-container">
														<ul id="sfbsort2" class="sfb-include-list ssbp-list sfbSortable">';
								$htmlFollowButtonsForm .= getSelectedSFB($arrSettings['sfb_selected_buttons']);
							$htmlFollowButtonsForm .= '</ul>
												</div>';
						$htmlFollowButtonsForm .= '</div>';
					$htmlFollowButtonsForm .= '</div>';
					$htmlFollowButtonsForm .= '<input type="hidden" name="sfb_selected_buttons" id="sfb_selected_buttons" value="'.$arrSettings['sfb_selected_buttons'].'"/>';

                    // show URLs button
                    $htmlFollowButtonsForm .= '<span class="btn btn-block btn-primary"
                                                            data-toggle="collapse"
                                                            data-target="#sfb-urls"
                                                            aria-expanded="false"
                                                            aria-controls="sfb-urls">
                                                            Set Follow URLs
                                                        </span>';

                    // the URLs well
                    $htmlFollowButtonsForm .= '<div class="collapse" id="sfb-urls">
                                                          <div class="well">';

                    // loop through each button
                    foreach ($arrButtons as $button => $arrButton) {
                        // empty vars for DRY
                        $prefix = '';
                        $suffix = '';

                        // if a button has a prefix and suffix
                        if (isset($arrButton['url_prefix']) && isset($arrButton['url_suffix'])) {
                            // prepare vars
                            $prefix = $arrButton['url_prefix'];
                            $suffix = $arrButton['url_suffix'];
                            $type = 'text_prefix_suffix';
                        }

                        // if a button has a prefix only
                        if (isset($arrButton['url_prefix']) && ! isset($arrButton['url_suffix'])) {
                            // prepare vars
                            $prefix = $arrButton['url_prefix'];
                            $type = 'text_prefix';
                        }

                        // if a button has a suffix only
                        if (! isset($arrButton['url_prefix']) && isset($arrButton['url_suffix'])) {
                            // prepare vars
                            $suffix = $arrButton['url_suffix'];
                            $type = 'text_suffix';
                        }

                        // if a button has neither a prefix nor a suffix
                        if (! isset($arrButton['url_prefix']) && ! isset($arrButton['url_suffix'])) {
                            // prepare vars
                            $type = 'text';
                        }

                        // button size
                        $opts = array(
                            'form_group'	=> false,
                            'type'          => $type,
                            'prefix'        => $prefix,
                            'suffix'       	=> $suffix,
                            'placeholder'   => 'simplefollowbuttons',
                            'name' => 'url_' . $button,
                            'label' => $arrButton['full_name'],
                            'tooltip' => 'Set your ' . $arrButton['full_name'] . ' URL',
                            'value' => (isset($arrSettings['url_' . $button]) ? $arrSettings['url_' . $button] : null),
                        );
                        $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);
                    }

                    // the URLs well
                    $htmlFollowButtonsForm .= '</div></div>';

				$htmlFollowButtonsForm .= '</div>';

			// close col
			$htmlFollowButtonsForm .= '</div>';

		// close follow buttons tab
		$htmlFollowButtonsForm .= '</div>';

		//======================================================================
		// 		STYLING
		//======================================================================
		$htmlFollowButtonsForm .= '<div class="tab-pane fade" id="styling">';

			// intro info
			$htmlFollowButtonsForm .= '<blockquote><p>Use the options below to choose your favourite button set and how it should appear. <strong>If you wish to upload your own custom images</strong> please select \'Custom\' from the Image Set dropdown.</p></blockquote>';

			// COLUMN --------------------------------
			$htmlFollowButtonsForm .= '<div class="col-sm-7">';

			    // IMAGES --------------------------------
                $htmlFollowButtonsForm .= '<div class="well">';

                    // heading
                    $htmlFollowButtonsForm .= '<h3>Images</h3>';

    				// placement
    	            $opts = array(
    	                'form_group'	=> false,
    	                'type'       	=> 'select',
    	                'name'          => 'sfb_image_set',
    	                'label'        	=> 'Image set',
    	                'tooltip'       => 'Choose your favourite set of buttons, or set to custom to choose your own',
    	                'selected'      => $arrSettings['sfb_image_set'],
    	                'options'       => array(
    	                                        'Arbenta'   => 'arbenta',
    	                                        'Custom'    => 'custom',
    	                                        'Metal'     => 'metal',
    	                                        'Pagepeel'  => 'pagepeel',
    	                                        'Plain'     => 'plain',
    	                                        'Retro'     => 'retro',
    	                                        'Ribbons'   => 'ribbons',
    	                                        'Simple'    => 'simple',
    	                                        'Somacro'   => 'somacro',
    	                                    ),
    	            );
    				$htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

    				// custom images well
                    $htmlFollowButtonsForm .= '<div id="sfb-custom-images" '.($arrSettings['sfb_image_set'] != 'custom' ? 'style="display: none;"' : NULL).'>';

                        // loop through each button
                        foreach ($arrButtons as $button => $arrButton) {
                            // enable custom images
                            $opts = array(
                                'form_group'    => false,
                                'type'          => 'image_upload',
                                'name'          => 'sfb_custom_'.$button,
                                'label'         => $arrButton['full_name'],
                                'tooltip'       => 'Upload a custom '.$arrButton['full_name'].' image',
                                'value'         => $arrSettings['sfb_custom_'.$button],
                            );
                            $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);
                        }

                    // close custom images
                    $htmlFollowButtonsForm .= '</div>';

                    // button size
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'number_addon',
                        'addon'       	=> 'px',
                        'placeholder'   => '35',
                        'name'          => 'sfb_size',
                        'label'        	=> 'Button Size',
                        'tooltip'       => 'Set the size of your buttons in pixels',
                        'value'         => $arrSettings['sfb_size'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // alignment
                    $opts = array(
                        'form_group'	=> false,
                        'type'       	=> 'select',
                        'name'          => 'sfb_align',
                        'label'        	=> 'Alignment',
                        'tooltip'       => 'Align your buttons the way you wish',
                        'selected'      => $arrSettings['sfb_align'],
                        'options'       => array(
                                                'Left'      => 'left',
                                                'Centre'    => 'center',
                                                'Right'     => 'right',
                                            ),
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // padding
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'number_addon',
                        'addon'       	=> 'px',
                        'placeholder'   => '10',
                        'name'          => 'sfb_padding',
                        'label'        	=> 'Padding',
                        'tooltip'       => 'Apply some space around your images',
                        'value'         => $arrSettings['sfb_padding'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // close images well
                $htmlFollowButtonsForm .= '</div>';

                // SHARE TEXT STYLING --------------------------------
                $htmlFollowButtonsForm .= '<div class="well">';

                    // heading
                    $htmlFollowButtonsForm .= '<h3>Follow Text</h3>';

                    // font colour
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'colorpicker',
                        'name'          => 'sfb_font_color',
                        'label'        	=> 'Font Colour',
                        'tooltip'       => 'Choose the colour of your follow text',
                        'value'         => $arrSettings['sfb_font_color'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // font family
                    $opts = array(
                        'form_group'	=> false,
                        'type'       	=> 'select',
                        'name'          => 'sfb_font_family',
                        'label'        	=> 'Font Family',
                        'tooltip'       => 'Choose a font available or inherit the font from your website',
                        'selected'      => $arrSettings['sfb_font_family'],
                        'options'       => array(
                                                'Reenie Beanie'             => 'Reenie Beanie',
                                                'Indie Flower'              => 'Indie Flower',
                                                'Inherit from my website'   => '',
                                            ),
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // font size
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'number_addon',
                        'addon'       	=> 'px',
                        'placeholder'   => '20',
                        'name'          => 'sfb_font_size',
                        'label'        	=> 'Font Size',
                        'tooltip'       => 'Set the size of the follow text in pixels',
                        'value'         => $arrSettings['sfb_font_size'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // font weight
                    $opts = array(
                        'form_group'	=> false,
                        'type'       	=> 'select',
                        'name'          => 'sfb_font_weight',
                        'label'        	=> 'Font Weight',
                        'tooltip'       => 'Set the weight of the follow text',
                        'selected'      => $arrSettings['sfb_font_weight'],
                        'options'       => array(
                                                'Bold'      => 'bold',
                                                'Normal'    => 'normal',
                                                'Light'     => 'light',
                                            ),
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // text placement
                    $opts = array(
                        'form_group'	=> false,
                        'type'       	=> 'select',
                        'name'          => 'sfb_text_placement',
                        'label'        	=> 'Text placement',
                        'tooltip'       => 'Choose where you want your text to be displayed, in relation to the buttons',
                        'selected'      => $arrSettings['sfb_text_placement'],
                        'options'       => array(
                                                'Above' => 'above',
                                                'Left'  => 'left',
                                                'Right' => 'right',
                                                'Below' => 'below',
                                            ),
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // close follow text well
                $htmlFollowButtonsForm .= '</div>';

                // CONTAINER TEXT STYLING --------------------------------
                $htmlFollowButtonsForm .= '<div class="well">';

                    // heading
                    $htmlFollowButtonsForm .= '<h3>Container</h3>';

                    // container padding
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'number_addon',
                        'addon'       	=> 'px',
                        'placeholder'   => '10',
                        'name'          => 'sfb_div_padding',
                        'label'        	=> 'Container Padding',
                        'tooltip'       => 'Add some padding to your follow container',
                        'value'         => $arrSettings['sfb_div_padding'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // div background colour
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'colorpicker',
                        'name'          => 'sfb_div_background',
                        'label'        	=> 'Container Background Colour',
                        'tooltip'       => 'Choose the colour of your follow container',
                        'value'         => $arrSettings['sfb_div_background'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // div border colour
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'colorpicker',
                        'name'          => 'sfb_div_border',
                        'label'        	=> 'Container Border Colour',
                        'tooltip'       => 'Choose the colour of your follow container border',
                        'value'         => $arrSettings['sfb_div_border'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // container border width
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'number_addon',
                        'addon'       	=> 'px',
                        'placeholder'   => '1',
                        'name'          => 'sfb_border_width',
                        'label'        	=> 'Container Border Width',
                        'tooltip'       => 'Set the width of the follow container border',
                        'value'         => $arrSettings['sfb_border_width'],
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                    // rounded container corners
                    $opts = array(
                        'form_group'	=> false,
                        'type'          => 'checkbox',
                        'name'          => 'sfb_div_rounded_corners',
                        'label'        	=> 'Rounded Container Corners',
                        'tooltip'       => 'Switch on to enable rounded corners for your follow container',
                        'value'         => 'Y',
                        'checked'       => ($arrSettings['sfb_div_rounded_corners'] == 'Y'  ? 'checked' : null),
                    );
                    $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // close container well
                $htmlFollowButtonsForm .= '</div>';

			// close col
			$htmlFollowButtonsForm .= '</div>';

			// COLUMN --------------------------------
			$htmlFollowButtonsForm .= '<div class="col-sm-5">';

			    // plus plug
			    $htmlFollowButtonsForm .= '<div class="well">';
    			    $htmlFollowButtonsForm .= '<h2>Get responsive</h2>';
    			    $htmlFollowButtonsForm .= '<p class="lead">Looking for <strong>fixed</strong> and <strong>responsive</strong> follow buttons?</p>';
    			    $htmlFollowButtonsForm .= '<p>With <strong>Simple Follow Buttons Plus</strong> you can pick from 10 different styles, that are all <strong>mobile-responsive</strong>. You can also pick icon/button colours and their hover colours!</p>';
    			    $htmlFollowButtonsForm .= '<div class="text-center sfb-spacer"><span class="text-20 label label-success">Only $5</span></div>';
    			    $htmlFollowButtonsForm .= '<a href="https://simplefollowbuttons.com/plus/?utm_source=adder&utm_medium=plugin_ad&utm_campaign=product&utm_content=styling_tab" target="_blank"><span class="sfb-spacer btn btn-block btn-primary">Get Plus!</span></a>';
    			    $htmlFollowButtonsForm .= '<div class="sfb-spacer"></div>';
			    $htmlFollowButtonsForm .= '</div>';

			// close col
			$htmlFollowButtonsForm .= '</div>';

		// close follow buttons tab
		$htmlFollowButtonsForm .= '</div>';

		//======================================================================
		// 		COUNTERS
		//======================================================================
//		$htmlFollowButtonsForm .= '<div class="tab-pane fade" id="counters">';
//
//			// intro info
//			$htmlFollowButtonsForm .= '<blockquote><p>You can tweak follow counter settings to your liking here.</p></blockquote>';
//
//			// COLUMN --------------------------------
//			$htmlFollowButtonsForm .= '<div class="col-sm-12">';
//
//                // follow count
//                $opts = array(
//                    'form_group'	=> false,
//                    'type'          => 'checkbox',
//                    'name'          => 'sfb_show_follow_count',
//                    'label'        	=> 'Follow Count',
//                    'tooltip'       => 'Check the box if you wish to enable follow counts. Enabling this option will slow down the loading of any pages that use follow buttons',
//                    'value'         => 'Y',
//                    'checked'       => ($arrSettings['sfb_show_follow_count'] == 'Y'  ? 'checked' : null),
//                );
//                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);
//
//                // show count once
//                $opts = array(
//                    'form_group'	=> false,
//                    'type'          => 'checkbox',
//                    'name'          => 'sfb_follow_count_once',
//                    'label'        	=> 'Show Once',
//                    'tooltip'       => 'This option is recommended, it deactivates follow counts for categories and archives allowing them to load more quickly',
//                    'value'         => 'Y',
//                    'checked'       => ($arrSettings['sfb_follow_count_once'] == 'Y'  ? 'checked' : null),
//                );
//                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);
//
//                // follow counters style
//                $opts = array(
//                    'form_group'	=> false,
//                    'type'       	=> 'select',
//                    'name'          => 'sfb_follow_count_style',
//                    'label'        	=> 'Counters Style',
//                    'tooltip'       => 'Pick a setting to style the follow counters',
//                    'selected'      => $arrSettings['sfb_follow_count_style'],
//                    'options'       => array(
//                                            'Default'	=> 'default',
//                                            'White'    	=> 'white',
//                                            'Blue'    	=> 'blue',
//                                        ),
//                );
//                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);
//
//			// close col
//			$htmlFollowButtonsForm .= '</div>';
//
////			// COLUMN --------------------------------
////			$htmlFollowButtonsForm .= '<div class="col-sm-5">';
////
////			    // plus plug
////			    $htmlFollowButtonsForm .= '<div class="well">';
////    			    $htmlFollowButtonsForm .= '<h2>Get speed and accuracy</h2>';
////    			    $htmlFollowButtonsForm .= '<p class="lead">Do you want <strong>fast</strong> and <strong>consistent follow counts</strong>?</p>';
////    			    $htmlFollowButtonsForm .= '<p>With <strong>Simple Follow Buttons Plus</strong> follow counts are saved for the length of time you set, drastically speeding up page load time. Plus also comes with use of the SSB API for <a href="https://simplefollowbuttons.com/plus/features/api/"><strong>consistent Facebook follow counts</strong></a></p>';
////    			    $htmlFollowButtonsForm .= '<img class="sfb-responsive-img" src="' . plugins_url() . '/simple-follow-buttons-adder/images/simple-follow-buttons-mockups.png' . '" />';
////    			    $htmlFollowButtonsForm .= '<div class="text-center sfb-spacer"><span class="text-20 label label-success">Only $10</span></div>';
////    			    $htmlFollowButtonsForm .= '<a href="https://simplefollowbuttons.com/plus/?utm_source=adder&utm_medium=plugin_ad&utm_campaign=product&utm_content=counters_tab" target="_blank"><span class="sfb-spacer btn btn-block btn-primary">Get Plus!</span></a>';
////    			    $htmlFollowButtonsForm .= '<div class="sfb-spacer"></div>';
////			    $htmlFollowButtonsForm .= '</div>';
////
////			// close col
////			$htmlFollowButtonsForm .= '</div>';
//
//		// close follow buttons tab
//		$htmlFollowButtonsForm .= '</div>';

		//======================================================================
		// 		ADVANCED
		//======================================================================
		$htmlFollowButtonsForm .= '<div class="tab-pane fade" id="advanced">';

			// intro info
			$htmlFollowButtonsForm .= '<blockquote><p>You\'ll find a number of advanced and miscellaneous options below, to get your follow buttons functioning how you would like.</p></blockquote>';

			// COLUMN --------------------------------
			$htmlFollowButtonsForm .= '<div class="col-sm-12">';

			    // link to ssb
                $opts = array(
                    'form_group'	=> false,
                    'type'          => 'checkbox',
                    'name'          => 'sfb_link_to_ssb',
                    'label'        	=> 'Follow Text Link',
                    'tooltip'       => 'Enabling this will set your follow text as a link to simplefollowbuttons.com to help others learn of the plugin',
                    'value'         => 'Y',
                    'checked'       => ($arrSettings['sfb_link_to_ssb'] == 'Y'  ? 'checked' : null),
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // content priority
                $opts = array(
                    'form_group'    => false,
                    'type'          => 'number',
                    'placeholder'   => '10',
                    'name'          => 'sfb_content_priority',
                    'label'         => 'Content Priority',
                    'tooltip'       => 'Set the priority for your follow buttons within your content. 1-10, default is 10',
                    'value'         => $arrSettings['sfb_content_priority'],
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // follow in new window
                $opts = array(
                    'form_group'	=> false,
                    'type'          => 'checkbox',
                    'name'          => 'sfb_follow_new_window',
                    'label'        	=> 'Open links in a new window',
                    'tooltip'       => 'Disabling this will make links open in the same window',
                    'value'         => 'Y',
                    'checked'       => ($arrSettings['sfb_follow_new_window'] == 'Y'  ? 'checked' : null),
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // nofollow
                $opts = array(
                    'form_group'	=> false,
                    'type'          => 'checkbox',
                    'name'          => 'sfb_rel_nofollow',
                    'label'        	=> 'Add rel="nofollow"',
                    'tooltip'       => 'Enable this to add nofollow to all follow links',
                    'value'         => 'Y',
                    'checked'       => ($arrSettings['sfb_rel_nofollow'] == 'Y'  ? 'checked' : null),
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // widget follow text
                $opts = array(
                    'form_group'    => false,
                    'type'          => 'text',
                    'placeholder'	=> 'Keeping sharing simple...',
                    'name'          => 'sfb_widget_text',
                    'label'        	=> 'Widget Follow Text',
                    'tooltip'       => 'Add custom follow text when used as a widget',
                    'value'         => $arrSettings['sfb_widget_text'],
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

			// close col
			$htmlFollowButtonsForm .= '</div>';

//			// COLUMN --------------------------------
//			$htmlFollowButtonsForm .= '<div class="col-sm-5">';
//
//			    // plus plug
//			    $htmlFollowButtonsForm .= '<div class="well">';
//    			    $htmlFollowButtonsForm .= '<h2>Get even more</h2>';
//    			    $htmlFollowButtonsForm .= '<p class="lead">Hoping for <strong>even more</strong> features?</p>';
//    			    $htmlFollowButtonsForm .= '<p>With <strong>Simple Follow Buttons Plus</strong> there is an ever-growing \'Advanced\' features section, including <strong>bit.ly</strong> URL shortening, <strong>Google Analytics Event Tracking</strong> and <strong>Follow-Meta</strong> Functionality.</p>';
//    			    $htmlFollowButtonsForm .= '<img class="sfb-responsive-img" src="' . plugins_url() . '/simple-follow-buttons-adder/images/simple-follow-buttons-mockups.png' . '" />';
//    			    $htmlFollowButtonsForm .= '<div class="text-center sfb-spacer"><span class="text-20 label label-success">Only $10</span></div>';
//    			    $htmlFollowButtonsForm .= '<a href="https://simplefollowbuttons.com/plus/?utm_source=adder&utm_medium=plugin_ad&utm_campaign=product&utm_content=advanced_tab" target="_blank"><span class="sfb-spacer btn btn-block btn-primary">Get Plus!</span></a>';
//    			    $htmlFollowButtonsForm .= '<div class="sfb-spacer"></div>';
//			    $htmlFollowButtonsForm .= '</div>';
//
//			// close col
//			$htmlFollowButtonsForm .= '</div>';

		// close follow buttons tab
		$htmlFollowButtonsForm .= '</div>';

		//======================================================================
        // 		ADDITIONAL CSS
        //======================================================================
        $htmlFollowButtonsForm .= '<div class="tab-pane fade" id="css_additional">';

            // intro info
            $htmlFollowButtonsForm .= '<blockquote><p>The contents of the text area below will be appended to Simple Follow Button\'s CSS.</p></blockquote>';

            // column for padding
            $htmlFollowButtonsForm .= '<div class="col-sm-12">';

                // additional css
                $opts = array(
                    'form_group'    => false,
                    'type'          => 'textarea',
                    'rows'          => '15',
                    'class'         => 'code-font',
                    'name'          => 'sfb_additional_css',
                    'label'         => 'Additional CSS',
                    'tooltip'       => 'Add your own additional CSS if you wish',
                    'value'         => $arrSettings['sfb_additional_css'],
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlFollowButtonsForm .= '</div>';

        // close additional css
        $htmlFollowButtonsForm .= '</div>';

        //======================================================================
        // 		CUSTOM CSS
        //======================================================================
        $htmlFollowButtonsForm .= '<div class="tab-pane fade" id="css_custom">';

            // intro info
            $htmlFollowButtonsForm .= '<blockquote><p>If you want to take over control of your follow buttons\' CSS entirely, turn on the switch below and enter your custom CSS. <strong>ALL of Simple Follow Buttons\'s CSS will be disabled</strong>.</p></blockquote>';

            // column for padding
            $htmlFollowButtonsForm .= '<div class="col-sm-12">';

                // enable custom css
                $opts = array(
                    'form_group'    => false,
                    'type'          => 'checkbox',
                    'name'          => 'sfb_custom_styles_enabled',
                    'label'         => 'Enable Custom CSS',
                    'tooltip'       => 'Switch on to disable all SFB styles and use your own custom CSS',
                    'value'         => 'Y',
                    'checked'       => ($arrSettings['sfb_custom_styles_enabled'] == 'Y'  ? 'checked' : null),
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

                // custom css
                $opts = array(
                    'form_group'    => false,
                    'type'          => 'textarea',
                    'rows'          => '15',
                    'class'         => 'code-font',
                    'name'          => 'sfb_custom_styles',
                    'label'         => 'Custom CSS',
                    'tooltip'       => 'Enter in your own custom CSS for your follow buttons',
                    'value'         => $arrSettings['sfb_custom_styles'],
                );
                $htmlFollowButtonsForm .= $ssbpForm->ssbp_input($opts);

            // close column
            $htmlFollowButtonsForm .= '</div>';

        // close custom css
        $htmlFollowButtonsForm .= '</div>';

	// close tab content div
	$htmlFollowButtonsForm .= '</div>';

	// close off form with save button
	$htmlFollowButtonsForm .= $ssbpForm->close();

	// add footer
	$htmlFollowButtonsForm .= sfb_admin_footer();

	echo $htmlFollowButtonsForm;
}

// get an html formatted of currently selected and ordered buttons
function getSelectedSFB($strSelectedSFB) {
    //variables
    $htmlSelectedList = '';

    // prepare array of buttons
    $arrButtons = json_decode(get_option('sfb_buttons'), true);

    // if there are some selected buttons
	if ($strSelectedSFB != '') {

		// explode saved include list and add to a new array
		$arrSelectedSFB = explode(',', $strSelectedSFB);

		// check if array is not empty
		if ($arrSelectedSFB != '') {

			// for each included button
			foreach ($arrSelectedSFB as $strSelected) {

				// add a list item for each selected option
				$htmlSelectedList .= '<li class="ssbp-option-item" id="'.$strSelected.'"><a title="'.$arrButtons[$strSelected]["full_name"].'" href="javascript:;" class="ssbp-btn ssbp-'.$strSelected.'"></a></li>';
			}
		}
	}

	// return html list options
	return $htmlSelectedList;
}

function getAvailableSFB($strSelectedSFB)
{
	// variables
	$htmlAvailableList = '';

	// prepare array of buttons
	$arrButtons = json_decode(get_option('sfb_buttons'), true);

	// explode saved include list and add to a new array
	$arrSelectedSFB = explode(',', $strSelectedSFB);

	// extract the available buttons
	$arrAvailableSFB = array_diff(array_keys($arrButtons), $arrSelectedSFB);

	// check if array is not empty
	if($arrSelectedSFB != '')
	{
		// for each included button
		foreach($arrAvailableSFB as $strAvailable)
		{
			// add a list item for each available option
			$htmlAvailableList .= '<li class="ssbp-option-item" id="'.$strAvailable.'"><a title="'.$arrButtons[$strAvailable]["full_name"].'" href="javascript:;" class="ssbp-btn ssbp-'.$strAvailable.'"></a></li>';
		}
	}

	// return html list options
	return $htmlAvailableList;
}

// get ssbp font family
function sfb_get_font_family()
{
	return "@font-face {
				font-family: 'ssbp';
				src:url('".plugins_url()."/simple-follow-buttons/fonts/ssbp.eot?xj3ol1');
				src:url('".plugins_url()."/simple-follow-buttons/fonts/ssbp.eot?#iefixxj3ol1') format('embedded-opentype'),
					url('".plugins_url()."/simple-follow-buttons/fonts/ssbp.woff?xj3ol1') format('woff'),
					url('".plugins_url()."/simple-follow-buttons/fonts/ssbp.ttf?xj3ol1') format('truetype'),
					url('".plugins_url()."/simple-follow-buttons/fonts/ssbp.svg?xj3ol1#ssbp') format('svg');
				font-weight: normal;
				font-style: normal;

				/* Better Font Rendering =========== */
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}";
}

