<?php
namespace ystp;

class ScrollInit {

    private static $instance = null;
    private $actions;
    private $filters;

    private function __construct() {
        $this->init();
    }

    private function __clone() {
    }

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init() {
	    register_activation_hook(YSTP_PREFIX, array($this, 'activate'));
	    register_deactivation_hook(YSTP_PREFIX, array($this, 'deactivate'));
	    add_action('admin_init', array($this, 'pluginRedirect'));
	    $this->includeData();
        $this->actions();
        $this->filters();
    }

    private function includeData() {
        require_once YSTP_HELPERS_PATH.'ConditionsConfig.php';
        if(YSTP_PKG_VERSION > YSTP_FREE_VERSION) {
            require_once YSTP_HELPERS_PATH.'ConditionsConfigPro.php';
        }
        require_once(YSTP_CLASSES_PATH.'ShowReviewNotice.php');
        require_once YSTP_HELPERS_PATH.'HelperFunctions.php';
        require_once YSTP_HELPERS_PATH.'ScriptsIncluder.php';
        require_once YSTP_CLASSES_PATH.'ConditionBuilder.php';
		if(YSTP_PKG_VERSION > YSTP_FREE_VERSION) {
			require_once YSTP_CLASSES_PATH.'ConditionsConditionBuilder.php';
		}
        require_once YSTP_CLASSES_PATH.'DisplayConditionBuilder.php';
        require_once YSTP_HELPERS_PATH.'MultipleChoiceButton.php';
        require_once YSTP_HELPERS_PATH.'AdminHelper.php';
        require_once YSTP_CLASSES_PATH.'ScrollType.php';
	    require_once YSTP_SCROLLS_PATH.'ScrollModel.php';
        require_once YSTP_SCROLLS_PATH.'Scroll.php';
        require_once YSTP_CSS_PATH.'Css.php';
        require_once YSTP_JS_PATH.'Js.php';
        require_once YSTP_CLASSES_PATH.'RegisterPostType.php';
        require_once YSTP_CLASSES_PATH.'Checker.php';
        require_once YSTP_CLASSES_PATH.'IncludeToPage.php';
        if(YSTP_PKG_VERSION > YSTP_FREE_VERSION) {
            require_once YSTP_CLASSES_PATH.'FiltersPro.php';
        }
        require_once YSTP_CLASSES_PATH.'Actions.php';
        require_once YSTP_CLASSES_PATH.'Ajax.php';
		require_once YSTP_CLASSES_PATH.'Filters.php';
		require_once YSTP_CLASSES_PATH.'Installer.php';
    }

    public function actions() {
        $this->actions = new Actions();
    }

    public function filters() {
        if(YSTP_PKG_VERSION > YSTP_FREE_VERSION) {
          $obj = new FiltersPro();
        }
        $this->filters = new Filters();
    }

    public function activate() {
	    Installer::install();
    }
    
    public function pluginRedirect() {
    	if (!get_option('ystp_redirect')) {
		    update_option('ystp_redirect', 1);
		    exit(wp_redirect(admin_url('edit.php?post_type='.YSTP_POST_TYPE)));
	    }
    }
    
    public function deactivate() {
	    delete_option('ystp_redirect');
    }
}

ScrollInit::getInstance();