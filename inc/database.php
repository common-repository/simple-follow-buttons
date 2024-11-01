<?php
defined('ABSPATH') or die('No direct access permitted');

// activate sfb function
function sfb_activate() {

    // likely a reactivation, return doing nothing
    if (get_option('sfb_version') !== false) {
        return;
    }

    // array ready with defaults
    $sfb_settings = array(
        'sfb_image_set' => 'somacro',
        'sfb_size' => '35',
        'sfb_pages' => '',
        'sfb_posts' => '',
        'sfb_align' => 'left',
        'sfb_padding' => '6',
        'sfb_before_or_after' => 'after',
        'sfb_additional_css' => '',
        'sfb_custom_styles' => '',
        'sfb_custom_styles_enabled' => '',
        'sfb_link_to_ssb' => 'N',
        'sfb_widget_text' => '',
        'sfb_rel_nofollow' => '',
        'sfb_content_priority' => '10',
        'sfb_follow_new_window' => 'Y',

        // follow container
        'sfb_div_padding' => '',
        'sfb_div_rounded_corners' => '',
        'sfb_border_width' => '',
        'sfb_div_border' => '',
        'sfb_div_background' => '',

        // follow text
        'sfb_follow_text' => "Follow",
        'sfb_text_placement' => 'left',
        'sfb_font_family' => 'Indie Flower',
        'sfb_font_color' => '',
        'sfb_font_size' => '20',
        'sfb_font_weight' => '',

        // include
        'sfb_selected_buttons' => 'facebook,google,twitter,linkedin',
    );

    // prepare array of buttons
    $arrButtons = sfb_button_helper_array();

    // update/add buttons helper
    update_option('sfb_buttons', json_encode($arrButtons));

    // loop through each button
    foreach ($arrButtons as $button => $arrButton) {
        // add custom button to array of options
        $sfb_settings['sfb_custom_'.$button] = '';
        $sfb_settings['url_'.$button] = '';
    }

    // json encode
    $jsonSettings = json_encode($sfb_settings);

    // insert default options for sfb
    add_option('sfb_settings', $jsonSettings);

    // sfb version
    add_option('sfb_version', SFB_VERSION);
}

// uninstall sfb
function sfb_uninstall() {

	//if uninstall not called from WordPress exit
	if (defined('WP_UNINSTALL_PLUGIN')) {
		exit();
	}

    // delete options
    delete_option('sfb_settings');
    delete_option('sfb_version');
}

// the upgrade function
function upgrade_sfb($arrSettings, $version) {

	// button helper array
	sfb_button_helper_array();

	// update version number
	update_option('sfb_version', SFB_VERSION);
}

// button helper option
function sfb_button_helper_array()
{
    // helper array for sfb
    return array(
        'diggit' => array(
            'full_name' => 'Diggit',
            'url_prefix' => 'http://digg.com/source/',
        ),
        'email' => array(
            'full_name'    => 'Email',
        ),
        'facebook' => array(
            'full_name'    => 'Facebook',
            'url_prefix' => 'https://www.facebook.com/',
        ),
        'google' => array(
            'full_name'    => 'Google+',
            'url_prefix' => 'https://plus.google.com/+',
        ),
        'linkedin' => array(
            'full_name'    => 'LinkedIn',
            'url_prefix' => 'https://linkedin.com/in/',
        ),
        'pinterest' => array(
            'full_name'    => 'Pinterest',
            'url_prefix' => 'https://www.pinterest.com/',
        ),
        'reddit' => array(
            'full_name'    => 'Reddit',
            'url_prefix' => 'https://www.reddit.com/user/',
        ),
        'tumblr' => array(
            'full_name'    => 'Tumblr',
            'url_prefix' => 'http://',
            'url_suffix' => '.tumblr.com',
        ),
        'twitter' => array(
            'full_name'    => 'Twitter',
            'url_prefix' => 'https://twitter.com/',
        ),
        'vk' => array(
            'full_name'    => 'VK',
            'url_prefix' => 'https://vk.com/',
        ),
        'yummly' => array(
            'full_name'    => 'Yummly',
            'url_prefix' => 'http://www.yummly.co.uk/page/',
        ),
    );
}
