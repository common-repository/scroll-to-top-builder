<?php

class YstpScrollConfig {
    public static function addDefine($name, $value) {
        if(!defined($name)) {
            define($name, $value);
        }
    }

    public static function init() {
        self::addDefine('YSTP_PREFIX', YSTP_FILE_NAME);
        self::addDefine('YSTP_ADMIN_URL', admin_url());
        self::addDefine('YSTP_BUILDER_URL', plugins_url().'/'.YSTP_FOLDER_NAME.'/');
        self::addDefine('YSTP_ADMIN_URL', admin_url());
        self::addDefine('YSTP_URL', plugins_url().'/'.YSTP_FOLDER_NAME.'/');
        self::addDefine('YSTP_ASSETS_URL', YSTP_URL.'assets/');
        self::addDefine('YSTP_CSS_URL', YSTP_ASSETS_URL.'css/');
        self::addDefine('YSTP_JS_URL', YSTP_ASSETS_URL.'js/');
        self::addDefine('YSTP_JS_ADMIN_URL', YSTP_JS_URL.'admin/');
        self::addDefine('YSTP_IMG_URL', YSTP_ASSETS_URL.'img/');
        self::addDefine('YSTP_LIB_URL', YSTP_URL.'lib/');
        self::addDefine('YSTP_PATH', WP_PLUGIN_DIR.'/'.YSTP_FOLDER_NAME.'/');
        self::addDefine('YSTP_CLASSES_PATH', YSTP_PATH.'classes/');
        self::addDefine('YSTP_LIBS_PATH', YSTP_PATH.'libs/');
        self::addDefine('YSTP_DATA_TABLE_PATH', YSTP_CLASSES_PATH.'dataTable/');
        self::addDefine('YSTP_LIB_PATH', YSTP_PATH.'lib/');
        self::addDefine('YSTP_HELPERS_PATH', YSTP_PATH.'helpers/');
        self::addDefine('YSTP_CONFIG_PATH', YSTP_PATH.'config/');
        self::addDefine('YSTP_ASSETS_PATH', YSTP_PATH.'/assets/');
        self::addDefine('YSTP_VIEWS_PATH', YSTP_ASSETS_PATH.'views/');
        self::addDefine('YSTP_VIEWS_ADMIN_PATH', YSTP_VIEWS_PATH.'admin/');
        self::addDefine('YSTP_TYPES_VIEWS_PATH', YSTP_VIEWS_PATH.'types/');
        self::addDefine('YSTP_PREVIEW_VIEWS_PATH', YSTP_VIEWS_PATH.'preview/');
        self::addDefine('YSTP_CSS_PATH', YSTP_ASSETS_PATH.'css/');
        self::addDefine('YSTP_JS_PATH', YSTP_ASSETS_PATH.'js/');
        self::addDefine('YSTP_SCROLLS_PATH', YSTP_CLASSES_PATH.'scrolls/');
        self::addDefine('YSTP_HELPERS_PATH', YSTP_PATH.'helpers/');
        self::addDefine('YSTP_POST_TYPE', 'ystpscroll');
        self::addDefine('YSTP_DEFAULT_TYPE', 'text');
	    self::addDefine('YSTP_POSTS_TABLE_NAME', 'posts');
        self::addDefine('YSTP_TEXT_DOMAIN', 'ystpScroll');
        self::addDefine('YSTP_SCROLL_ADD_NEW', 'ystpscroll');
        self::addDefine('YSTP_PRO_URL', 'https://edmonsoft.com/scroll-to-top/');
        self::addDefine('YSTP_REVIEW_URL', 'https://wordpress.org/support/plugin/scroll-to-top-builder/reviews/?filter=5');
        self::addDefine('YSTP_SUPPORT_URL', 'https://wordpress.org/support/plugin/scroll-to-top-builder/');
	    self::addDefine('YSTP_FILTER_REPEAT_INTERVAL', 50);
	    self::addDefine('YSTP_CRON_REPEAT_INTERVAL', 1);
	    self::addDefine('YSTP_TABLE_LIMIT', 15);
        self::addDefine('YSTP_VERSION', 1.33);
        self::addDefine('YSTP_VERSION_TEXT', '1.3.3');
        self::addDefine('YSTP_LAST_UPDATE_DATE', 'Nov 2');
        self::addDefine('YSTP_NEXT_UPDATE_DATE', 'Dec 10');
        self::addDefine('YSTP_VERSION_PRO', 1.24);
        self::addDefine('YSTP_IMAGES_COUNT', 25);
        self::addDefine('YSTP_AJAX_SUCCESS', 1);
        self::addDefine('YSTP_SHOW_REVIEW_PERIOD', 30);
        self::addDefine('YSTP_FREE_VERSION', 1);
        self::addDefine('YSTP_SILVER_VERSION', 2);
        self::addDefine('YSTP_GOLD_VERSION', 3);
        self::addDefine('YSTP_PLATINUM_VERSION', 4);
        require_once(dirname(__FILE__).'/config-pkg.php');
    }

    public static function getVersionString() {
	    $version = 'YSTP_VERSION='.YSTP_VERSION;
	    if(YSTP_PKG_VERSION > YSTP_FREE_VERSION) {
		    $version = 'YSTP_VERSION_PRO=' . YSTP_VERSION_PRO.";";
	    }

	    return $version;
    }

    public static function headerScript() {
		$version = self::getVersionString();

		ob_start();
		?>
			<script type="text/javascript">
				<?= $version; ?>
			</script>
	    <?php
	    $content = ob_get_contents();
	    ob_get_clean();

	    return $content;
    }
}

YstpScrollConfig::init();