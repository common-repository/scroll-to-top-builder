<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}
use ystp\Installer;
if (!defined('YSTP_FILE_NAME')) {
	define('YSTP_FILE_NAME', plugin_basename(__FILE__));
}

if (!defined('YSTP_FOLDER_NAME')) {
	define('YSTP_FOLDER_NAME', plugin_basename(dirname(__FILE__)));
}

require_once(plugin_dir_path(__FILE__).'config/boot.php');
require_once(YSTP_CLASSES_PATH.'Installer.php');
Installer::uninstall();
