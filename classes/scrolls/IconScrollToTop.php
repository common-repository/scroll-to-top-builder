<?php
namespace ystp;

class IconScrollToTop extends Scroll {
	
	public function __construct() {
		add_filter('ystpGeneralMetaboxes', array($this, 'addMetabox'), 10, 1);
	}
	
	public function addMetabox($metaboxes) {
		$metaboxes['mainOptions'] = array('title' => 'Main options', 'position' => 'normal', 'prioritet' => 'high', 'currentObj' => $this);
		
		return $metaboxes;
	}
	
	public function mainOptions() {
		require_once YSTP_TYPES_VIEWS_PATH.'iconMainOption.php';
	}

	public function getButton() {
	    $id = $this->getId();
		$fontSize = $this->getOptionValue('ystp-icon-font-size');
		$savedButtonType = $this->getOptionValue('ystp-icon-type');
		$button = '<span class="ystp-scroll-to-top-icon ystp-scroll-to-top-icon-'.$id.' ystp-'.$savedButtonType.'" ></span>';
		$button .= '<style>';
		$button .= '.ystp-scroll-to-top-icon:before {';
		$button .= 'font-size: '.$fontSize.'px !important;';
		$button .= '}';
		$button .= '</style>';

        $button = apply_filters('ystpIconContent', $button, $this);

		return $button;
	}

	public function getViewContent() {
		ScriptsIncluder::registerStyle('fonts.css', array('dirUrl' => YSTP_CSS_URL.'fonts/'));
		ScriptsIncluder::enqueueStyle('fonts.css', array('dirUrl' => YSTP_CSS_URL.'fonts/'));
		return $this->getButton();
	}
}