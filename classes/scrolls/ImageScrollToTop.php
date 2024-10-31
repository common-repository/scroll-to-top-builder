<?php
namespace ystp;

class ImageScrollToTop extends Scroll {
	public function __construct() {
		add_filter('ystpGeneralMetaboxes', array($this, 'addMetabox'), 10, 1);
	}

	public function addMetabox($metaboxes) {
		$metaboxes['mainOptions'] = array('title' => 'Main options', 'position' => 'normal', 'prioritet' => 'high', 'currentObj' => $this);
		
		return $metaboxes;
	}

	public function mainOptions() {
		require_once YSTP_TYPES_VIEWS_PATH.'imageMainOption.php';
	}
	
	public function getViewContent() {
	    $imageURL = $this->getOptionValue('ystp-image-url');
        $image = '<img src="'.$imageURL.'">';

		return $image;
	}
}