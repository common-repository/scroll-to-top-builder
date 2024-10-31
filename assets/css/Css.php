<?php
namespace ystp;

class Css {

    public function __construct() {
        $this->init();
    }

    public function init() {

        add_action('admin_enqueue_scripts', array($this, 'enqueueStyles'));
    }
	
	public function getAddNewPageKey() {
		return YSTP_POST_TYPE.'_page_'.YSTP_SCROLL_ADD_NEW;
	}
	
	public function morePluginsPage() {
		return YSTP_POST_TYPE.'_page_ystp-more-plugins-page';
	}

    public function enqueueStyles($hook) {
    	
		$addNew = $this->getAddNewPageKey();
		$morePluginsPage = $this->morePluginsPage();
	    $allowedPages = array(
		    $addNew,
		    $morePluginsPage
	    );
        if(in_array($hook, $allowedPages) || get_post_type(@$_GET['post']) == YSTP_POST_TYPE) {
	        ScriptsIncluder::registerStyle('admin.css');
	        ScriptsIncluder::registerStyle('bootstrap.css');
	        ScriptsIncluder::registerStyle('select2.css');
	        ScriptsIncluder::registerStyle('ion.rangeSlider.skinFlat.css');
	        ScriptsIncluder::registerStyle('ion.rangeSlider.css');

            if(YSTP_PKG_VERSION > YSTP_FREE_VERSION) {
                ScriptsIncluder::registerStyle('colorpicker.css');
                ScriptsIncluder::enqueueStyle('colorpicker.css');
            }
            ScriptsIncluder::registerStyle('generalStyle.css');
            ScriptsIncluder::enqueueStyle('generalStyle.css');

	        ScriptsIncluder::enqueueStyle('bootstrap.css');
	        ScriptsIncluder::enqueueStyle('admin.css');
	        ScriptsIncluder::enqueueStyle('select2.css');
            ScriptsIncluder::enqueueStyle('ion.rangeSlider.css');
	        ScriptsIncluder::enqueueStyle('ion.rangeSlider.skinFlat.css');
        }
    }
}

new Css();