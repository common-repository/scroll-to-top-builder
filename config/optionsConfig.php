<?php

class YstpOptionsConfig {

    public static function init() {
        global $YSTP_TYPES;

        $YSTP_TYPES['typeName'] = apply_filters('ystpTypes', array(
	        'text' => 1,
	        'icon' => 1,
	        'image' => 1
        ));

        $YSTP_TYPES['typePath'] = apply_filters('ystpTypePaths', array(
	        'text' => YSTP_SCROLLS_PATH,
	        'icon' => YSTP_SCROLLS_PATH,
	        'image' => YSTP_SCROLLS_PATH
        ));
        
        $YSTP_TYPES['titles'] = apply_filters('ystpTitles', array(
	        'text' => __('Text type', YSTP_TEXT_DOMAIN),
	        'icon' => __('Icon type', YSTP_TEXT_DOMAIN),
	        'image' => __('Image type', YSTP_TEXT_DOMAIN)
        ));
    }

    public static function optionsValues() {
        global $YSTP_OPTIONS;
        $options = array();
	    $options[] = array('name' => 'ystp-animation-speed', 'type' => 'text', 'defaultValue' => '1000');
        $options[] = array('name' => 'ystp-show-after', 'type' => 'text', 'defaultValue' => '100');
	    $options[] = array('name' => 'ystp-button-text', 'type' => 'text', 'defaultValue' => __('Scroll to Top', YSTP_TEXT_DOMAIN));
	    $options[] = array('name' => 'ystp-icon-type', 'type' => 'text', 'defaultValue' => 'arrow1');
	    $options[] = array('name' => 'ystp-text-font-size', 'type' => 'text', 'defaultValue' => '16px');
	    $options[] = array('name' => 'ystp-icon-font-size', 'type' => 'text', 'defaultValue' => '25');
	    $options[] = array('name' => 'ystp-button-position', 'type' => 'text', 'defaultValue' => 'bottom-right');
	    $options[] = array('name' => 'ystp-margin-x', 'type' => 'text', 'defaultValue' => 20);
	    $options[] = array('name' => 'ystp-margin-y', 'type' => 'text', 'defaultValue' => 20);
	    $options[] = array('name' => 'ystp-scroll-opacity', 'type' => 'text', 'defaultValue' => 1);
	    $options[] = array('name' => 'ystp-z-index', 'type' => 'text', 'defaultValue' => 9999);
	    $options[] = array('name' => 'ystp-scroll-behavior', 'type' => 'text', 'defaultValue' => 'default');
	    $options[] = array('name' => 'ystp-image-url', 'type' => 'text', 'defaultValue' => YSTP_IMG_URL.'1.png');
	    $options[] = array('name' => 'ystp-text-type-font-weight', 'type' => 'text', 'defaultValue' => 'normal');
	    $options[] = array('name' => 'ystp-scroll-show-after', 'type' => 'text', 'defaultValue' => 'default');
	    $options[] = array('name' => 'ystp-scroll-class-name', 'type' => 'text', 'defaultValue' => '');

	    $options[] = array('name' => 'ystp-display-settings', 'type' => 'ystp', 'defaultValue' => array(array('key1' => 'everywhere','key2' => 'is', 'key3' => array())));
	    $options[] = array('name' => 'ystp-display-conditions', 'type' => 'ystp', 'defaultValue' => array(array('key1' => 'select_settings')));
        
        $YSTP_OPTIONS = apply_filters('ystpDefaultOptions', $options);
    }
    
    public static function getDefaultInsertData() {
    	$defaultInsertData = array();
    	self::optionsValues();
    	global $YSTP_OPTIONS;
		$defaults = $YSTP_OPTIONS;
		
	    $options = array(
		    'ystp-type',
		    'ystp-scroll-show-after',
		    'ystp-show-after',
		    'ystp-show-after-measure',
		    'ystp-show-after-selector',
		    'ystp-scroll-behavior',
		    'ystp-scroll-to-selector',
		    'ystp-animation-speed',
		    'ystp-animation-behavior',
		    'ystp-button-position',
		    'ystp-margin-x',
		    'ystp-margin-y',
		    'ystp-scroll-opacity',
		    'ystp-z-index',
		    'ystp-scroll-title',
		    'ystp-showing-animation',
		    'ystp-scroll-class-name',
		    'ystp-custom-css',
		    'ystp-custom-js',
		    'ystp-button-text',
		    'ystp-text-font-size',
		    'ystp-text-type-font-weight',
		    'ystp-text-type-font-family',
		    'ystp-text-type-color'
	    );
	    
	    foreach ($options as $option) {
	    	foreach ($defaults as $default) {
	    		if ($default['name'] == $option) {
				    $defaultInsertData[$option] = $default['defaultValue'];
				    continue;
			    }
		    }
	    }
	    
	    return $defaultInsertData;
    }

	public static function getDefaultTimezone() {
		$timezone = get_option('timezone_string');
		if (!$timezone) {
			$timezone = 'America/New_York';
		}

		return $timezone;
	}
}

YstpOptionsConfig::init();