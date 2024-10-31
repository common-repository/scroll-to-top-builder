<?php
namespace ystp;

class Js {

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
	}

	public function enqueueStyles($hook) {
		$allowedPages = array(
		);
		
		ScriptsIncluder::registerScript('ConditionBuilder.js', array('dirUrl' => YSTP_JS_ADMIN_URL));
		ScriptsIncluder::registerScript('Admin.js');
		ScriptsIncluder::registerScript('AdminPro.js');
		ScriptsIncluder::registerScript('select2.js');
        ScriptsIncluder::registerScript('ionRangeSlider.js');

        wp_enqueue_media();

		if(in_array($hook, $allowedPages) || get_post_type(@$_GET['post']) == YSTP_POST_TYPE) {
			ScriptsIncluder::localizeScript('Admin.js', 'ystp_admin_localized', array(
				'nonce' => wp_create_nonce('ystp_ajax_nonce'),
				'imageURL' => YSTP_IMG_URL,
				'adminUrl' => admin_url()
			));
            if(function_exists('wp_enqueue_code_editor')) {
                wp_enqueue_code_editor(array( 'type' => 'text/html'));
            }
			if(YSTP_PKG_VERSION > YSTP_FREE_VERSION) {
                ScriptsIncluder::registerScript('minicolors.js');
                ScriptsIncluder::enqueueScript('minicolors.js');
                ScriptsIncluder::enqueueScript('AdminPro.js');
            }
			ScriptsIncluder::enqueueScript('select2.js');
			ScriptsIncluder::enqueueScript('ionRangeSlider.js');
			ScriptsIncluder::enqueueScript('Admin.js');
			ScriptsIncluder::enqueueScript('ConditionBuilder.js', array('dirUrl' => YSTP_JS_ADMIN_URL));
		}
	}
}

new Js();