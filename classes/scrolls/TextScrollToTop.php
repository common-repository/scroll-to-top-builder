<?php
namespace ystp;

class TextScrollToTop extends Scroll {
	public function __construct() {
		add_filter('ystpGeneralMetaboxes', array($this, 'addMetabox'), 10, 1);
	}

	public function addMetabox($metaboxes) {
		$metaboxes['mainOptions'] = array('title' => 'Main options', 'position' => 'normal', 'prioritet' => 'high', 'currentObj' => $this);
		
		return $metaboxes;
	}

	public function mainOptions() {
		require_once YSTP_TYPES_VIEWS_PATH.'textMainOption.php';
	}

	private function includeScripts() {
	    if(YSTP_PKG_VERSION > 1) {
            wp_register_script('ycdGoogleFonts', YSTP_JS_URL.'ycdGoogleFonts.js');
            wp_enqueue_script('ycdGoogleFonts');
        }
    }
	public function getViewContent() {
	    $this->includeScripts();
	    $fontSize = $this->getOptionValue('ystp-text-font-size');
	    $fontWeight = $this->getOptionValue('ystp-text-type-font-weight');
	    $id = $this->getId();
	    $button = '<span>'.$this->getOptionValue('ystp-button-text').'</span>';
        $button .= '<style>';
        $button .= '.ystp-content-'.$id.' {font-size: '.$fontSize.' !important; font-weight: '.$fontWeight.' !important;}';
        $button .= '</style>';

        $button = apply_filters('ystpTextContent', $button, $this);

		return $button;
	}
}