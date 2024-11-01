<?php
/*
Plugin Name: Simple Follow Buttons
Plugin URI: https://simplefollowbuttons.com
Description: A simple plugin that enables you to add follow buttons to all of your posts and/or pages.
Version: 1.0.0
Author: Simple Share Buttons
Author URI: https://simplefollowbuttons.com
License: GPLv2

Copyright 2015 Simple Follow Buttons admin@simplefollowbuttons.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
    __     _ _            _         _   _
   / _|___| | |_____ __ _| |__ _  _| |_| |_ ___ _ _  ___
  |  _/ _ \ | / _ \ V  V / '_ \ || |  _|  _/ _ \ ' \(_-<
  |_| \___/_|_\___/\_/\_/|_.__/\_,_|\__|\__\___/_||_/__/

 */

//======================================================================
// 		CONSTANTS
//======================================================================

	define('SFB_FILE', __FILE__);
    define('SFB_ROOT', dirname(__FILE__));
	define('SFB_VERSION', '1.0.0');

//======================================================================
// 		 SFB SETTINGS
//======================================================================

	// make sure we have settings ready
	$arrSettings = get_sfb_settings();

//======================================================================
// 		INCLUDES
//======================================================================

    include_once plugin_dir_path(__FILE__).'/inc/admin_bits.php';
    include_once plugin_dir_path(__FILE__).'/inc/buttons.php';
    include_once plugin_dir_path(__FILE__).'/inc/styles.php';
    include_once plugin_dir_path(__FILE__).'/inc/widget.php';
    include_once plugin_dir_path(__FILE__).'/inc/database.php';

//======================================================================
// 		ACTIVATE/DEACTIVATE HOOKS
//======================================================================

    // run the activation function upon acitvation of the plugin
    register_activation_hook( __FILE__,'sfb_activate');

    // register deactivation hook
    register_uninstall_hook(__FILE__,'sfb_uninstall');

//======================================================================
// 		GET SFB SETTINGS
//======================================================================

    // return sfb settings
    function get_sfb_settings()
    {
        // get json array settings from DB
        $jsonSettings = get_option('sfb_settings');

        // decode and return settings
        return json_decode($jsonSettings, true);
    }

//======================================================================
// 		UPDATE SFB SETTINGS
//======================================================================

    // update an array of options
    function sfb_update_options($arrOptions)
    {
        // if not given an array
        if (! is_array($arrOptions)) {
            die('Value parsed not an array');
        }

        // get sfb settings
        $jsonSettings = get_option('sfb_settings');

        // decode the settings
        $sfb_settings = json_decode($jsonSettings, true);

        // loop through array given
        foreach ($arrOptions as $name => $value) {
            // update/add the option in the array
            $sfb_settings[$name] = $value;
        }

        // encode the options ready to save back
        $jsonSettings = json_encode($sfb_settings);

        // update the option in the db
        update_option('sfb_settings', $jsonSettings);
    }
