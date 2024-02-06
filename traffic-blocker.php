<?php
/*
Plugin Name: Traffic Block by Country
Description: Block traffic from specific countries
Version: 1.0
Author: ht3tmytat
Author URI: http://htetmyat.dev
License: GPL2
*/

// Define constants for easy access to file paths and URLs
define('TFBC_FILE', __FILE__); // Absolute path to the main plugin file
define('TFBC_DIR', plugin_dir_path(__FILE__)); // Directory path of the plugin

// Include the functions file
require(TFBC_DIR . 'tfbc-functions.php');
