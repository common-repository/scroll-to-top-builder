<?php
namespace ystp;

class ScriptsIncluder {
    /**
     * Scroll register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     * @param array $args wordpress register  style args dep|ver|media|dirUrl
     *
     * @return void
     */
    public static function registerStyle($fileName, $args = array()) {
        if(empty($fileName)) {
            return;
        }
        $dep = array();
        $ver = YSTP_VERSION;
        $media = 'all';
        $dirUrl = YSTP_CSS_URL;

        if(!empty($args['dep'])) {
            $dep = $args['dep'];
        }

        if(!empty($args['ver'])) {
            $ver = $args['ver'];
        }

        if(!empty($args['media'])) {
            $media = $args['media'];
        }

        if(!empty($args['dirUrl'])) {
            $dirUrl = $args['dirUrl'];
        }
        
        wp_register_style($dirUrl.$fileName, $dirUrl.''.$fileName, $dep, $ver, $media);
    }

    /**
     * Scroll register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     *
     * @return void
     */
    public static function enqueueStyle($fileName, $args = array()) {
        if(empty($fileName)) {
            return;
        }
	    $dirUrl = YSTP_CSS_URL;
	
	    if(!empty($args['dirUrl'])) {
		    $dirUrl = $args['dirUrl'];
	    }
	    
        wp_enqueue_style($dirUrl.$fileName);
    }

    /**
     * Scroll register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     * @param array $args wordpress register  script args dep|ver|inFooter|dirUrl
     *
     * @return void
     */
    public static function registerScript($fileName, $args = array()) {
        if(empty($fileName)) {
            return;
        }

        $dep = array();
        $ver = YSTP_VERSION;
        $inFooter = false;
        $dirUrl = YSTP_JS_URL;

        if(!empty($args['dep'])) {
            $dep = $args['dep'];
        }

        if(!empty($args['ver'])) {
            $ver = $args['ver'];
        }

        if(!empty($args['inFooter'])) {
            $inFooter = $args['inFooter'];
        }

        if(!empty($args['dirUrl'])) {
            $dirUrl = $args['dirUrl'];
        }

        wp_register_script($dirUrl.$fileName, $dirUrl.''.$fileName, $dep, $ver, $inFooter);
    }

    /**
     * Scroll register style
     *
     * @since 1.0.0
     *
     * @param string $fileName file address
     *
     * @return void
     */
    public static function enqueueScript($fileName, $args = array()) {
        if(empty($fileName)) {
            return;
        }
	    $dirUrl = YSTP_JS_URL;
        
        if(!empty($args['dirUrl'])) {
            $dirUrl = $args['dirUrl'];
        }
        wp_enqueue_script($dirUrl.$fileName);
    }

    public static function localizeScript($handle, $name, $data) {
	    $dirUrl = YSTP_JS_URL;
        wp_localize_script($dirUrl.$handle, $name, $data);
    }
    
    public static function loadScript($scriptName) {
	    self::registerScript($scriptName);
	    self::enqueueScript($scriptName);
    }
}