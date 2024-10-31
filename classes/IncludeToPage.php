<?php
namespace ystp;
use \WP_Query;

class IncludeToPage {
	private $posts = array();
	
	public function pushToPosts($post) {
		$this->posts[] = $post;
	}
	
	public function getPosts() {
		return $this->posts;
	}
	
	public function includeData() {
		$this->getSavedData();
		$this->includeToPage();
	}
	
	private function getSavedData() {
		$posts = new WP_Query(
			array(
				'post_type'      => YSTP_POST_TYPE,
				'posts_per_page' => - 1
			)
		);
		$checker = new Checker();
		// We check all the scroll one by one to realize whether they might be loaded or not.
		while($posts->have_posts()) {
			$posts->next_post();
			$currentPost = $posts->post;
			$id = $currentPost->ID;
			$scroll = Scroll::find($id);
			$checker->setObj($scroll);
			
			if(!$checker->isAllow()) {
				continue;
			}
			$this->pushToPosts($scroll);
		}
	}
	
	public function includeToPage() {
		$scrolls = $this->getPosts();
		
		if(empty($scrolls)) {
			return false;
		}
		
		foreach($scrolls as $scroll) {
			$this->addToFooter($scroll);
		}
		$this->includeScripts();
	}
	
	public function addToFooter($scroll) {
		$id = $scroll->getId();
		$options = $scroll->getSavedData();
		$options['id'] = $id;
		$options = json_encode($options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
		$content = $scroll->getViewContent();
		$styles = $scroll->getCurrentStyles();
		$title = $scroll->getOptionValue('ystp-scroll-title');
		$className = $scroll->getOptionValue('ystp-scroll-class-name');
		$customArgs = array('title' => $title, 'className' => $className);
        $content = apply_filters('ystpContent', $content, $scroll);
		
		add_action('wp_footer', function() use ($id, $options, $content, $styles, $customArgs) {
			$title = $customArgs['title'];
			$className = $customArgs['className'];
			
			$footerScrollContent = '<div style="position:fixed; bottom: -999999999999999999999px;">
                <div class="'.$className.' ystp-content" id="ystp-content-wrapper-'.$id.'" data-hide-str="position:fixed; bottom: -999999999999999999999px;" data-styles="'.esc_attr($styles).'" data-id="'.esc_attr($id).'" data-options="'.esc_attr($options).'">
                    <div class="ystp-content-'.esc_attr($id).' ystp-content-html" title="'.esc_attr($title).'">'.$content.'</div>
                </div>
            </div>';
			
			echo $footerScrollContent;
		});
	}
	
	public function includeScripts() {
		if(YSTP_PKG_VERSION == YSTP_FREE_VERSION) {
			wp_enqueue_script('jquery-effects-core');
		}
		ScriptsIncluder::registerScript('Scroll.js', array('dep' => array('jquery')));
		ScriptsIncluder::enqueueScript('Scroll.js');
	}
}