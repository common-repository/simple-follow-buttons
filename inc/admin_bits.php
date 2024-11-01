<?php
defined('ABSPATH') or die('No direct access permitted');

// add settings link on plugin page
function sfb_settings_link($links)
{
	// add to plugins links
	array_unshift($links, '<a href="options-general.php?page=simple-follow-buttons">Settings</a>');

	// return all links
	return $links;
}

// include js files and upload script
function sfb_admin_scripts()
{
	// all extra scripts needed
	wp_enqueue_media();
	wp_enqueue_script('media-upload');
	wp_register_script('sfb-bootstrap-js', plugins_url('/js/bootstrap.js', SFB_FILE ));
	wp_enqueue_script('sfb-bootstrap-js');
	wp_register_script('sfb-colorpicker-js', plugins_url('/js/colorpicker.js', SFB_FILE ));
	wp_enqueue_script('sfb-colorpicker-js');
	wp_register_script('sfb-switch-js', plugins_url('/js/switch.js', SFB_FILE ));
	wp_enqueue_script('sfb-switch-js');
	wp_register_script('sfb-admin-js', plugins_url('/js/admin.js', SFB_FILE ));
	wp_enqueue_script('sfb-admin-js');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui');
}

// include styles for the sfb admin panel
function sfb_admin_styles()
{
	// admin styles
	wp_register_style('sfb-readable', plugins_url('/css/readable.css', SFB_FILE ));
	wp_enqueue_style('sfb-readable');
	wp_register_style('sfb-colorpicker', plugins_url('/css/colorpicker.css', SFB_FILE ));
	wp_enqueue_style('sfb-colorpicker');
	wp_register_style('sfb-switch', plugins_url('/css/switch.css', SFB_FILE ));
	wp_enqueue_style('sfb-switch');
	wp_register_style('sfb-admin-theme', plugins_url('/css/admin-theme.css', SFB_FILE ));
	wp_enqueue_style('sfb-admin-theme');
	wp_register_style('ssbp-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
	wp_enqueue_style('ssbp-font-awesome');
	wp_register_style('sfb-styles', plugins_url('/css/style.css', SFB_FILE ));
	wp_enqueue_style('sfb-styles');
}

// add filter hook for plugin action links
add_filter('plugin_action_links_' . plugin_basename(SFB_FILE), 'sfb_settings_link' );

// add menu to dashboard
add_action( 'admin_menu', 'sfb_menu' );

// check if viewing the admin page
if (isset($_GET['page']) && $_GET['page'] == 'simple-follow-buttons') {

	// add the registered scripts
	add_action('admin_print_styles', 'sfb_admin_styles');
	add_action('admin_print_scripts', 'sfb_admin_scripts');
}

// menu settings
function sfb_menu()
{
	// add menu page
	add_options_page( 'Simple Follow Buttons', 'Follow Buttons', 'manage_options', 'simple-follow-buttons', 'sfb_settings');

	// query the db for current sfb settings
	$arrSettings = get_sfb_settings();

	// get the current version
	$version = get_option('sfb_version');

	// there was a version set
	if ($version !== false) {
        // check if not updated to current version
    	if ($version < SFB_VERSION) {
    		// run the upgrade function
    		upgrade_sfb($arrSettings, $version);
    	}
	}
}

// answer form
function sfb_settings() {

	// check if user has the rights to manage options
	if (! current_user_can('manage_options')) {

		// permissions message
		wp_die( __('You do not have sufficient permissions to access this page.'));
	}

	// if a post has been made
	if(isset($_POST['sfbData']))
	{
		// get posted data
		$sfbPost = $_POST['sfbData'];
		parse_str($sfbPost, $sfbPost);

		// if the nonce doesn't check out...
		if ( ! isset($sfbPost['sfb_save_nonce']) || ! wp_verify_nonce($sfbPost['sfb_save_nonce'], 'sfb_save_settings')) {
			die('There was no nonce provided, or the one provided did not verify.');
		}

        // prepare array
        $arrOptions = array(
            'sfb_image_set' => $sfbPost['sfb_image_set'],
    		'sfb_size' => $sfbPost['sfb_size'],
    		'sfb_pages' => (isset($sfbPost['sfb_pages']) ? $sfbPost['sfb_pages'] : NULL),
    		'sfb_posts' => (isset($sfbPost['sfb_posts']) ? $sfbPost['sfb_posts'] : NULL),
    		'sfb_cats_archs' => (isset($sfbPost['sfb_cats_archs']) ? $sfbPost['sfb_cats_archs'] : NULL),
    		'sfb_homepage' => (isset($sfbPost['sfb_homepage']) ? $sfbPost['sfb_homepage'] : NULL),
    		'sfb_excerpts' => (isset($sfbPost['sfb_excerpts']) ? $sfbPost['sfb_excerpts'] : NULL),
    		'sfb_align' => (isset($sfbPost['sfb_align']) ? $sfbPost['sfb_align'] : NULL),
    		'sfb_padding' => $sfbPost['sfb_padding'],
    		'sfb_before_or_after' => $sfbPost['sfb_before_or_after'],
    		'sfb_additional_css' => $sfbPost['sfb_additional_css'],
    		'sfb_custom_styles' => $sfbPost['sfb_custom_styles'],
    		'sfb_custom_styles_enabled' => $sfbPost['sfb_custom_styles_enabled'],
    		'sfb_email_message' => stripslashes_deep($sfbPost['sfb_email_message']),
    		'sfb_twitter_text' => stripslashes_deep($sfbPost['sfb_twitter_text']),
    		'sfb_buffer_text' => stripslashes_deep($sfbPost['sfb_buffer_text']),
    		'sfb_flattr_user_id' => stripslashes_deep($sfbPost['sfb_flattr_user_id']),
    		'sfb_flattr_url' => stripslashes_deep($sfbPost['sfb_flattr_url']),
    		'sfb_follow_new_window' => (isset($sfbPost['sfb_follow_new_window']) ? $sfbPost['sfb_follow_new_window'] : NULL),
    		'sfb_link_to_ssb' => (isset($sfbPost['sfb_link_to_ssb']) ? $sfbPost['sfb_link_to_ssb'] : NULL),
    		'sfb_show_follow_count' => (isset($sfbPost['sfb_show_follow_count']) ? $sfbPost['sfb_show_follow_count'] : NULL),
    		'sfb_follow_count_style' => $sfbPost['sfb_follow_count_style'],
    		'sfb_follow_count_css' => $sfbPost['sfb_follow_count_css'],
    		'sfb_follow_count_once' => (isset($sfbPost['sfb_follow_count_once']) ? $sfbPost['sfb_follow_count_once'] : NULL),
    		'sfb_widget_text' => $sfbPost['sfb_widget_text'],
    		'sfb_rel_nofollow' => (isset($sfbPost['sfb_rel_nofollow']) ? $sfbPost['sfb_rel_nofollow'] : NULL),
    		'sfb_default_pinterest' => (isset($sfbPost['sfb_default_pinterest']) ? $sfbPost['sfb_default_pinterest'] : NULL),
    		'sfb_pinterest_featured' => (isset($sfbPost['sfb_pinterest_featured']) ? $sfbPost['sfb_pinterest_featured'] : NULL),
    		'sfb_content_priority'  => (isset($sfbPost['sfb_content_priority']) ? $sfbPost['sfb_content_priority'] : NULL),

    		// follow container
    		'sfb_div_padding' => $sfbPost['sfb_div_padding'],
    		'sfb_div_rounded_corners' => (isset($sfbPost['sfb_div_rounded_corners']) ? $sfbPost['sfb_div_rounded_corners'] : NULL),
    		'sfb_border_width' => $sfbPost['sfb_border_width'],
    		'sfb_div_border' => $sfbPost['sfb_div_border'],
    		'sfb_div_background' => $sfbPost['sfb_div_background'],

    		// text
    		'sfb_follow_text' => stripslashes_deep($sfbPost['sfb_follow_text']),
    		'sfb_text_placement' => $sfbPost['sfb_text_placement'],
    		'sfb_font_family' => $sfbPost['sfb_font_family'],
    		'sfb_font_color' => $sfbPost['sfb_font_color'],
    		'sfb_font_size' => $sfbPost['sfb_font_size'],
    		'sfb_font_weight' => $sfbPost['sfb_font_weight'],

    		// included buttons
    		'sfb_selected_buttons' => $sfbPost['sfb_selected_buttons'],
        );

        // prepare array of buttons
        $arrButtons = json_decode(get_option('sfb_buttons'), true);

        // loop through each button
        foreach ($arrButtons as $button => $arrButton) {
            // add custom button to array of options
            $arrOptions['sfb_custom_'.$button] = $sfbPost['sfb_custom_'.$button];
            $arrOptions['url_'.$button] = $sfbPost['url_'.$button];
        }

		 // save the settings
        sfb_update_options($arrOptions);

        // return success
		return true;
	}

	// include then run the upgrade script
	include_once (plugin_dir_path(SFB_FILE) . '/inc/admin_panel.php');

	// query the db for current sfb settings
	$arrSettings = get_sfb_settings();

	// --------- ADMIN PANEL ------------ //
	sfb_admin_panel($arrSettings);
}
