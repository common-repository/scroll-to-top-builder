<?php
namespace ystp;

class Filters {

    public function __construct() {
        $this->init();
    }

    public function init() {
        add_filter('admin_url', array($this, 'addNewPostUrl'), 10, 2);
	    add_filter('post_updated_messages' , array($this, 'updatedMessages'), 10, 1);
	    add_filter('manage_'.YSTP_POST_TYPE.'_posts_columns' , array($this, 'tableColumns'));
        add_filter('ystpAnimationBehavior', array($this, 'animationBehavior'), 10, 1);
        add_filter('ystpSavedData', array($this, 'ystpSavedData'), 10, 1);
        add_filter('ystpContent', array($this, 'ystpContent'), 10, 2);
	    add_filter('post_row_actions', array($this, 'duplicatePost'), 10, 2);
    }
	
	public function duplicatePost($actions, $post) {
		if (current_user_can('edit_posts') && $post->post_type == YSTP_POST_TYPE) {
			$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=ystp_duplicate_post_as_draft&post=' . $post->ID, YSTP_POST_TYPE, 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Clone</a>';
		}
		return $actions;
	}

    public function ystpContent($content, $obj) {
        if(!empty($obj->getOptionValue('ystp-custom-css'))) {
            $content .= '<style type="text/css">'.$obj->getOptionValue('ystp-custom-css').'</style>';
        }
        if(!empty($obj->getOptionValue('ystp-custom-js'))) {
            $content .= '<script type="text/javascript">'.$obj->getOptionValue('ystp-custom-js').'</script>';
        }

        return $content;
    }

    public function ystpSavedData($savedData) {
        if(empty($savedData['ystp-animation-behavior'])) {
            return $savedData;
        }
        $animation = $savedData['ystp-animation-behavior'];
      
        if(YSTP_PKG_VERSION == YSTP_FREE_VERSION && $animation != 'linear' && $animation != 'swing') {
            $savedData['ystp-animation-behavior'] = 'swing';
        }

        return $savedData;
    }

    public function animationBehavior($easings) {

        if(empty($easings)) {
            return $easings;
        }

        foreach($easings as $key => $value) {

            if(YSTP_PKG_VERSION == YSTP_FREE_VERSION && $key != 'linear' && $key != 'swing') {
                $easings[$key] = $value.' (PRO) ';
            }
        }

        return $easings;
    }
	
	public function tableColumns($columns) {
        unset($columns['date']);
        $columns['onof'] = __('Enabled', YSTP_TEXT_DOMAIN);
		$columns['ystpType'] = __('Type', YSTP_TEXT_DOMAIN);
		
		return $columns;
	}
    
    public function updatedMessages($messages) {
    	$currentPostType = AdminHelper::getCurrentPostType();
        if ($currentPostType != YSTP_POST_TYPE) {
        	return $messages;
        }
	    $messages[YSTP_POST_TYPE][1] = 'Scroll to Top updated.';
	    $messages[YSTP_POST_TYPE][6] = 'Scroll to Top published.';
	    $messages[YSTP_POST_TYPE][7] = 'Scroll to Top saved.';
     
	    return $messages;
	}

    public function addNewPostUrl($url, $path) {
        if ($path == 'post-new.php?post_type='.YSTP_POST_TYPE) {
            $url = str_replace('post-new.php?post_type='.YSTP_POST_TYPE, 'edit.php?post_type='.YSTP_POST_TYPE.'&page='.YSTP_POST_TYPE, $url);
        }

        return $url;
    }
}