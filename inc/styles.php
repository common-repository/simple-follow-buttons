<?php
defined('ABSPATH') or die('No direct access permitted');

// call scripts add function
add_action( 'wp_enqueue_scripts', 'sfb_page_scripts' );

// add css scripts for page/post use
function sfb_page_scripts() {
    // sfb.min.js
    wp_enqueue_script('sfb', plugins_url('js/sfb.min.js', SFB_FILE), array('jquery'), false, true);

	// get settings
	$arrSettings = get_sfb_settings();

	// if indie flower font is selected
	if ($arrSettings['sfb_font_family'] == 'Indie Flower') {
		// font scripts
		wp_register_style('sfbFont', '//fonts.googleapis.com/css?family=Indie+Flower');
		wp_enqueue_style( 'sfbFont');
	} else if ($arrSettings['sfb_font_family'] == 'Reenie Beanie') {
		// font scripts
		wp_register_style('sfbFont', '//fonts.googleapis.com/css?family=Reenie+Beanie');
		wp_enqueue_style( 'sfbFont');
	}
}

// add CSS to the head
add_action( 'wp_head', 'get_sfb_style' );

// generate style
function get_sfb_style() {

	// query the db for current sfb settings
	$arrSettings = get_sfb_settings();

	// css style
	$htmlSFBStyle = '<style type="text/css">';

	// check if custom styles haven't been set
	if ($arrSettings['sfb_custom_styles_enabled'] != 'Y') {

		// use set options
		$htmlSFBStyle .= '	.sfb {
									' . ($arrSettings['sfb_div_padding'] 			!= ''	? 'padding: ' 	. $arrSettings['sfb_div_padding'] . 'px;' : NULL) . '
									' . ($arrSettings['sfb_border_width'] 			!= ''	? 'border: ' . $arrSettings['sfb_border_width'] . 'px solid ' 	. $arrSettings['sfb_div_border'] . ';' : NULL) . '
									' . ($arrSettings['sfb_div_background'] 		!= ''	? 'background-color: ' 	. $arrSettings['sfb_div_background'] . ';' : NULL) . '
									' . ($arrSettings['sfb_div_rounded_corners'] 	== 'Y'	? '-moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px;  border-radius: 10px; -o-border-radius: 10px;' : NULL) . '
								}
								.sfb img
								{
									width: ' . $arrSettings['sfb_size'] . 'px !important;
									padding: ' . $arrSettings['sfb_padding'] . 'px;
									border:  0;
									box-shadow: none !important;
									display: inline !important;
									vertical-align: middle;
								}
								.sfb, .sfb a
								{
									text-decoration:none;
									border:0;
									' . ($arrSettings['sfb_div_background'] == ''	? 'background: none;' : NULL) . '
									' . ($arrSettings['sfb_font_family'] 	!= ''	? 'font-family: ' . $arrSettings['sfb_font_family'] . ';' : NULL) . '
									' . ($arrSettings['sfb_font_size']		!= ''	? 'font-size: 	' . $arrSettings['sfb_font_size'] . 'px;' : NULL) . '
									' . ($arrSettings['sfb_font_color'] 	!= ''	? 'color: 		' . $arrSettings['sfb_font_color'] . '!important;' : NULL) . '
									' . ($arrSettings['sfb_font_weight'] 	!= ''	? 'font-weight: ' . $arrSettings['sfb_font_weight'] . ';' : NULL) . '
								}';

//        // if counters option is set to Y
//		if ($arrSettings['sfb_show_follow_count'] == 'Y') {
//			// styles that apply to all counter css sets
//			$htmlSFBStyle .= '.sfb_followcount:after, .sfb_followcount:before {
//									right: 100%;
//									border: solid transparent;
//									content: " ";
//									height: 0;
//									width: 0;
//									position: absolute;
//									pointer-events: none;
//								}
//								.sfb_followcount:after {
//									border-color: rgba(224, 221, 221, 0);
//									border-right-color: #f5f5f5;
//									border-width: 5px;
//									top: 50%;
//									margin-top: -5px;
//								}
//								.sfb_followcount:before {
//									border-color: rgba(85, 94, 88, 0);
//									border-right-color: #e0dddd;
//									border-width: 6px;
//									top: 50%;
//									margin-top: -6px;
//								}
//								.sfb_followcount {
//									font: 11px Arial, Helvetica, sans-serif;
//
//									padding: 5px;
//									-khtml-border-radius: 6px;
//									-o-border-radius: 6px;
//									-webkit-border-radius: 6px;
//									-moz-border-radius: 6px;
//									border-radius: 6px;
//									position: relative;
//									border: 1px solid #e0dddd;';
//
//			// if default counter style has been chosen
//			if ($arrSettings['sfb_follow_count_style'] == 'default') {
//
//				// style follow count
//				$htmlSFBStyle .= 	'color: #555e58;
//										background: #f5f5f5;
//									}
//									.sfb_followcount:after {
//										border-right-color: #f5f5f5;
//									}';
//
//			} elseif ($arrSettings['sfb_follow_count_style'] == 'white') {
//
//				// show white style follow counts
//				$htmlSFBStyle .= 	'color: #555e58;
//										background: #ffffff;
//									}
//									.sfb_followcount:after {
//										border-right-color: #ffffff;
//									}';
//
//			} elseif ($arrSettings['sfb_follow_count_style'] == 'blue') {
//
//				// show blue style follow counts
//				$htmlSFBStyle .= 	'color: #ffffff;
//										background: #42a7e2;
//									}
//									.sfb_followcount:after {
//										border-right-color: #42a7e2;
//									}';
//			}
//		}

		// if there's any additional css
		if ($arrSettings['sfb_additional_css'] != '') {
    		// add the additional CSS
    		$htmlSFBStyle .= $arrSettings['sfb_additional_css'];
		}
	}

	// else use set options
	else {

		// use custom styles
		$htmlSFBStyle .= $arrSettings['sfb_custom_styles'];
	}

	// close style tag
	$htmlSFBStyle .= '</style>';

	// return
	echo $htmlSFBStyle;

}
