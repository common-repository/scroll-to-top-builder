<?php
namespace ystp;

class Actions {
	public $customPostTypeObj;

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action('init', array($this, 'postTypeInit'));
		add_action('admin_menu', array($this, 'addSubMenu'));
		add_action('add_meta_boxes', array($this, 'addMetaboxes'), 10, 2);
		add_action('save_post_'.YSTP_POST_TYPE, array($this, 'save'), 10, 3);
		add_action('manage_'.YSTP_POST_TYPE.'_posts_custom_column' , array($this, 'tableColumnValues'), 10, 2);
		add_action('wp_enqueue_scripts', array($this, 'wpEnqueueScript'));
        add_action('admin_head', array($this, 'adminHead'));
		add_action('admin_action_ystp_duplicate_post_as_draft', array($this, 'duplicatePostSave'));
	}
	
	public function duplicatePostSave() {
		
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die('No post to duplicate has been supplied!');
		}
		/*
		 * Nonce verification
		 */
		if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], YSTP_POST_TYPE))
			return;
		
		/*
		 * get the original post id
		 */
		$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		/*
		 * and all the original post data then
		 */
		$post = get_post( $post_id );
		
		/*
		 * if you don't want current user to be the new post author,
		 * then change next couple of lines to this: $new_post_author = $post->post_author;
		 */
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
		
		/*
		 * if post data exists, create the post duplicate
		 */
		if (isset( $post ) && $post != null) {
			
			/*
			 * new post data array
			 */
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'publish',
				'post_title'     => $post->post_title.'(clone)',
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
			
			/*
			 * insert the post by wp_insert_post() function
			 */
			$new_post_id = wp_insert_post( $args );
			
			/*
			 * get all current post terms ad set them to the new post draft
			 */
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
			
			/*
			 * duplicate all post meta just in two SQL queries
			 */
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
			
			
			/*
			 * finally, redirect to the edit post screen for the new draft
			 */
			wp_redirect(admin_url('edit.php?post_type=' . YSTP_POST_TYPE));
			exit;
		} else {
			wp_die('Post creation failed, could not find original post: ' . $post_id);
		}
	}

    public function adminHead() {
        echo "<script>jQuery(document).ready(function() {jQuery('a[href*=\"page=ystp-support-page\"]').css({color: 'yellow'});jQuery('a[href*=\"page=ystp-support-page\"]').bind('click', function(e) {e.preventDefault(); window.open('https://wordpress.org/support/plugin/scroll-to-top-builder/')}) });</script>";
        echo "<script>jQuery(document).ready(function() {jQuery('a[href*=\"page=ystp-ideas-page\"]').css({color: 'rgb(85, 239, 195)'});jQuery('a[href*=\"page=ystp-ideas-page\"]').bind('click', function(e) {e.preventDefault(); window.open('https://wordpress.org/support/plugin/scroll-to-top-builder/')}) });</script>";
    }
	
	public function tableColumnValues($column, $postId) {
		$scroll = Scroll::find($postId);
		if($column == 'ystpType') {
			if(is_object($scroll)) {
				echo $scroll->getDisplayName();
			}
			else {
				_e('Unknown type', YSTP_TEXT_DOMAIN);
			}
		}
		if($column == 'onof') {
			$checked = '';
			$isActive = Scroll::isActivePost($postId);
			
			if ($isActive) {
				$checked = 'checked';
			}
			
			?>
			<label class="ystp-switch">
				<input type="checkbox" data-id="<?php echo esc_attr($postId); ?>" name="ystp-show-status" class="ystp-accordion-checkbox ystp-show-status" <?php echo $checked; ?> >
				<span class="ystp-slider ystp-round"></span>
			</label>
			<?php
		}
	}
	
	public function wpEnqueueScript() {
		$include = new IncludeToPage();
		$include->includeData();
	}
	
	public function hideMetaboxes($hidden, $screen) {
		if (('post' == $screen->base) && (YSTP_POST_TYPE == $screen->id)) {
			$hidden[] ='hiddenMetaboxes';//for custom meta box, enter the id used in the add_meta_box() function.
		}
		
		return $hidden;
	}
	
	public function save($postId, $post, $update) {
		if(!$update) {
			return false;
		}
		$safePost = filter_input_array(INPUT_POST);
		$postData = Scroll::parseScrollDataFromData($safePost);

		$postData = apply_filters('ystpSavedData', $postData);
		if(empty($postData)) {
			return false;
		}
		$postData['ystp-post-id'] = $postId;

		if (!empty($postData['ystp-type'])) {
			$type = $postData['ystp-type'];
			$typePath = Scroll::getTypePathFormScrollType($type);
			$className = Scroll::getClassNameScrollType($type);
			
			require_once($typePath.$className.'.php');
			$className = __NAMESPACE__.'\\'.$className;
			
			$className::create($postData);
		}
		return true;
	}
	
	public function defaultMainMetaboxes() {
		$metaboxes = array();
		
		$metaboxes['hiddenMetaboxes'] = array('title' => 'hidden options', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['customFunctionality'] = array('title' => 'Custom functionality', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['generalMetaboxes'] = array('title' => 'General options', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['displaySettings'] = array('title' => 'Display settingss', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['conditionsSection'] = array('title' => 'Conditions', 'position' => 'normal', 'prioritet' => 'high');
		$metaboxes['infoMetabox'] = array('title' => 'Info', 'position' => 'side', 'prioritet' => 'high');
		$metaboxes['supportMetabox'] = array('title' => 'Support', 'position' => 'side', 'prioritet' => 'high');
		
		return $metaboxes;
	}
	
	public function getMetaBoxes() {
		$metaboxes = $this->defaultMainMetaboxes();
		
		return apply_filters('ystpGeneralMetaboxes', $metaboxes);
	}
	
	public function addMetaboxes() {
		$metaboxes = $this->getMetaBoxes();
		
		foreach ($metaboxes as $key => $metabox) {
			$obj = $this;
			if(isset($metabox['currentObj'])) {
				$obj = $metabox['currentObj'];
			}
			add_meta_box($key, __($metabox['title'], YSTP_TEXT_DOMAIN), array($obj, $key), YSTP_POST_TYPE, $metabox['position'], $metabox['prioritet']);
		}
	}
	
	public function hiddenMetaboxes() {
		$typeObj = $this->customPostTypeObj->getTypeObj();
		require_once YSTP_VIEWS_PATH.'hiddenOptions.php';
	}
	
	public function generalMetaboxes() {
		$typeObj = $this->customPostTypeObj->getTypeObj();
		require_once YSTP_VIEWS_PATH.'generalOptions.php';
	}
	
	public function customFunctionality() {
		$typeObj = $this->customPostTypeObj->getTypeObj();
		require_once YSTP_VIEWS_ADMIN_PATH.'customFunctionality.php';
	}

	public function displaySettings() {
		$typeObj = $this->customPostTypeObj->getTypeObj();
		require_once YSTP_VIEWS_PATH.'displaySettings.php';
	}

	public function conditionsSection() {
		if(YSTP_PKG_VERSION == YSTP_FREE_VERSION) {
			return require_once YSTP_VIEWS_PATH.'conditionsFreeSection.php';
		}
		$typeObj = $this->customPostTypeObj->getTypeObj();
		require_once YSTP_VIEWS_PATH.'conditionsSection.php';
	}
	
	public function supportMetabox() {
	    require_once YSTP_VIEWS_ADMIN_PATH.'/support.php';
    }
    
    public function infoMetabox() {
	    require_once YSTP_VIEWS_ADMIN_PATH.'/info.php';
    }

	public function postTypeInit(){
		$this->customPostTypeObj = new RegisterPostType();
		add_filter('default_hidden_meta_boxes', array($this, 'hideMetaboxes'),10,2);
        $this->revieNotice();
	}

	private function revieNotice() {
        add_action('admin_notices', array($this, 'showReviewNotice'));
        add_action('network_admin_notices', array($this, 'showReviewNotice'));
        add_action('user_admin_notices', array($this, 'showReviewNotice'));
    }

	public function showReviewNotice() {
        echo new YstpShowReviewNotice();
	}
	
	public function addSubMenu() {
		$this->customPostTypeObj->addSubMenu();
	}
}
