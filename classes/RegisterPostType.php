<?php
namespace ystp;
use \YstpOptionsConfig;

class RegisterPostType {

    private $typeObj;
    private $type;
    private $id;
	
    public function __construct() {
        $this->init();
	    
	    return true;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return (int)$this->id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

    public function setTypeObj($typeObj) {
        $this->typeObj = $typeObj;
    }

    public function getTypeObj() {
        return $this->typeObj;
    }

    public function init() {
        $postType = YSTP_POST_TYPE;
	    add_filter('ystpPostTypeSupport', array($this, 'postTypeSupports'), 10, 1);
        $args = $this->getPostTypeArgs();

        register_post_type($postType, $args);

        if(@$_GET['post_type'] || get_post_type(@$_GET['post']) == YSTP_POST_TYPE) {
            $this->createCdObjFromCdType();
        }
	    YstpOptionsConfig::optionsValues();
    }

	public function postTypeSupports($supports) {

		$id = $this->getId();
		$type = $this->getTypeName();
		$typePath = Scroll::getTypePathFormScrollType($type);
		$className = Scroll::getClassNameScrollType($type);

		if (!file_exists($typePath.$className.'.php')) {
			return $supports;
		}
		
		require_once $typePath.$className.'.php';
		$className = __NAMESPACE__.'\\'.$className;
		if (!class_exists($className)) {
			return $supports;
		}

		if (method_exists($className, 'getTypeSupports')) {
			$supports = $className::getTypeSupports();
		}

		return $supports;
	}

    private function createCdObjFromCdType() {
        $id = 0;

        if (!empty($_GET['post'])) {
            $id = (int)$_GET['post'];
        }

        $type = $this->getTypeName();
        $this->setType($type);
        $this->setId($id);

        $this->createCdObj();
    }

    public function createCdObj()
    {
        $id = $this->getId();
        $type = $this->getType();
        $typePath = Scroll::getTypePathFormScrollType($type);
        $className = Scroll::getClassNameScrollType($type);

        if (!file_exists($typePath.$className.'.php')) {
            wp_die(__($className.' class does not exist', YSTP_TEXT_DOMAIN));
        }
        require_once($typePath.$className.'.php');
        $className = __NAMESPACE__.'\\'.$className;
	    if (!class_exists($className)) {
		    wp_die(__($className.' class does not exist', YSTP_TEXT_DOMAIN));
	    }
	    $id = $this->getId();
	    
        $typeObj = new $className();
        $typeObj->setId($id);
        $this->setTypeObj($typeObj);
    }

    private function getTypeName() {
        $type = YSTP_DEFAULT_TYPE;

        /*
         * First, we try to find the Scroll type with the post id then,
         * if the post id doesn't exist, we try to find it with $_GET['ystp_type']
         */
        if (!empty($_GET['post'])) {
            $id = (int)$_GET['post'];
            $cdOptionsData = Scroll::getPostSavedData($id);
            if (!empty($cdOptionsData['ystp-type'])) {
                $type = $cdOptionsData['ystp-type'];
            }
        }
        else if (!empty($_GET['ystp_type'])) {
            $type = $_GET['ystp_type'];
        }

        return $type;
    }

    public function getPostTypeArgs()
    {
        $labels = $this->getPostTypeLabels();

        $args = array(
            'labels'             => $labels,
            'description'        => __('Description.', 'your-plugin-textdomain'),
            //Exclude_from_search
            'public'             => true,
	        'has_archive'        => true,
            //Where to show the post type in the admin menu
            'show_ui'            => true,
            'query_var'          => false,
            // post preview button
            'publicly_queryable' => false,
	        'map_meta_cap'       => true,
            'capability_type'    => 'post',
            'menu_position'      => 10,
            'supports'           => apply_filters('ystpPostTypeSupport', array('title')),
            'menu_icon'          => 'dashicons-arrow-up-alt2'
        );

        return $args;
    }

    public function getPostTypeLabels()
    {
        $labels = array(
            'name'               => _x('Scroll to Top', 'post type general name', YSTP_TEXT_DOMAIN),
            'singular_name'      => _x('Scroll to Top', 'post type singular name', YSTP_TEXT_DOMAIN),
            'menu_name'          => _x('Scroll to Top', 'admin menu', YSTP_TEXT_DOMAIN),
            'name_admin_bar'     => _x('ScrollToTop', 'add new on admin bar', YSTP_TEXT_DOMAIN),
            'add_new'            => _x('Add New', 'Scroll to Top', YSTP_TEXT_DOMAIN),
            'add_new_item'       => __('Add New Scroll to Top', YSTP_TEXT_DOMAIN),
            'new_item'           => __('New Scroll to Top', YSTP_TEXT_DOMAIN),
            'edit_item'          => __('Edit Scroll to Top', YSTP_TEXT_DOMAIN),
            'view_item'          => __('View Item', YSTP_TEXT_DOMAIN),
            'all_items'          => __('All Items', YSTP_TEXT_DOMAIN),
            'search_items'       => __('Search Scroll to Tops', YSTP_TEXT_DOMAIN),
            'parent_item_colon'  => __('Parent Scroll to Top:', YSTP_TEXT_DOMAIN),
            'not_found'          => __('No item found.', YSTP_TEXT_DOMAIN),
            'not_found_in_trash' => __('No item found in Trash.', YSTP_TEXT_DOMAIN)
        );

        return $labels;
    }

    public function addSubMenu() {
		 add_submenu_page(
            'edit.php?post_type='.YSTP_POST_TYPE,
            __('Scroll Types', YSTP_TEXT_DOMAIN), // page title
            __('Scroll Types', YSTP_TEXT_DOMAIN), // menu title
            'read', 
            YSTP_POST_TYPE,
            array($this, 'postTypePage')
        );
        add_submenu_page(
            'edit.php?post_type='.YSTP_POST_TYPE,
            __('More Ideas?', YSTP_TEXT_DOMAIN),
            __('More Ideas?', YSTP_TEXT_DOMAIN),
            'read',
            'ystp-ideas-page',
            array($this, 'supportPage')
        );
        add_submenu_page(
            'edit.php?post_type='.YSTP_POST_TYPE,
            __('Support', YSTP_TEXT_DOMAIN),
            __('Support', YSTP_TEXT_DOMAIN),
            'read',
            'ystp-support-page',
            array($this, 'supportPage')
        );
        add_submenu_page(
            'edit.php?post_type='.YSTP_POST_TYPE,
            __('More Plugins', YSTP_TEXT_DOMAIN),
            __('More Plugins', YSTP_TEXT_DOMAIN),
            'read',
            'ystp-more-plugins-page',
            array($this, 'morePlugins')
        );
    }
    
    public function morePlugins() {
	    require_once YSTP_VIEWS_ADMIN_PATH.'morePlugins.php';
    }

    public function supportPage() {

    }
	
	public function postTypePage() {
		require_once YSTP_VIEWS_PATH.'typesPage.php';
	}
}