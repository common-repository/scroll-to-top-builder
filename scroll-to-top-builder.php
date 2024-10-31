<?php
/**
 * Plugin Name: Scroll to top builder
 * Description: Scroll to top customizable plugin.
 * Version: 1.3.3
 * Author: Adam Skaat
 * Author URI:
 * License: GPLv2
 */

/*If this file is called directly, abort.*/
if(!defined('WPINC')) {
    wp_die();
}

if(!defined('YSTP_FILE_NAME')) {
    define('YSTP_FILE_NAME', plugin_basename(__FILE__));
}

if(!defined('YSTP_FOLDER_NAME')) {
    define('YSTP_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(plugin_dir_path(__FILE__).'config/boot.php');
require_once(plugin_dir_path(__FILE__).'ScrollInit.php');