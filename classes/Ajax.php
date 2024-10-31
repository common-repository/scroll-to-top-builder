<?php
namespace ystp;
use \DateTime;

class Ajax {

	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action('wp_ajax_ystp-switch', array($this, 'switchScroll'));
		add_action('wp_ajax_ystp_select2_search_data', array($this, 'select2Ajax'));
		add_action('wp_ajax_ystp_edit_conditions_row', array($this, 'conditionsRow'));
		add_action('wp_ajax_ystp_add_conditions_row', array($this, 'conditionsRow'));

        add_action('wp_ajax_ystp_dont_show_review_notice', array($this, 'dontShowReview'));
        add_action('wp_ajax_ystp_change_review_show_period', array($this, 'changeReviewPeriod'));
	}

    public function changeReviewPeriod() {
        check_ajax_referer('ystpReviewNotice', 'ajaxNonce');
        $messageType = sanitize_text_field($_POST['messageType']);

        $timeDate = new DateTime('now');
        $timeDate->modify('+'.YSTP_SHOW_REVIEW_PERIOD.' day');

        $timeNow = strtotime($timeDate->format('Y-m-d H:i:s'));
        update_option('YstpShowNextTime', $timeNow);
        $usageDays = get_option('YstpUsageDays');
        $usageDays += YSTP_SHOW_REVIEW_PERIOD;
        update_option('YstpUsageDays', $usageDays);

        echo YSTP_AJAX_SUCCESS;
		wp_die();
	}

	public function dontShowReview() {
	    check_ajax_referer('ystpReviewNotice', 'ajaxNonce');
        pdate_option('YstpDontShowReviewNotice', 1);

        echo YSTP_AJAX_SUCCESS;
		wp_die();
 	}
	
	public function switchScroll() {
		check_ajax_referer('ystp_ajax_nonce', 'nonce');
		$postId = (int)$_POST['id'];
		$checked = $_POST['checked'] == 'true' ? '' : true;
		update_post_meta($postId, 'ystp_enable', $checked);
		
		echo 1;
		wp_die();
	}

	public function select2Ajax() {
		check_ajax_referer('ystp_ajax_nonce', 'nonce_ajax');

		$postTypeName = sanitize_text_field($_POST['postType']);
		$search = sanitize_text_field($_POST['searchTerm']);

		$args      = array(
			's'              => $search,
			'post__in'       => ! empty( $_REQUEST['include'] ) ? array_map( 'intval', $_REQUEST['include'] ) : null,
			'page'           => ! empty( $_REQUEST['page'] ) ? absint( $_REQUEST['page'] ) : null,
			'posts_per_page' => 100,
			'post_type'      => $postTypeName
		);

		$searchResults = AdminHelper::getPostTypeData($args);

		if (empty($searchResults)) {
			$results['items'] = array();
		}

		/*Selected custom post type convert for select2 format*/
		foreach ($searchResults as $id => $name) {
			$results['items'][] = array(
				'id'   => $id,
				'text' => $name
			);
		}

		echo json_encode($results);
		wp_die();
	}

	public function conditionsRow() {
		check_ajax_referer('ystp_ajax_nonce', 'nonce');
		$selectedParams = sanitize_text_field($_POST['selectedParams']);
		$conditionId = (int)$_POST['conditionId'];
		$childClassName = $_POST['conditionsClassName'];
		$childClassName = __NAMESPACE__.'\\'.$childClassName;
		$obj = new $childClassName();

		echo $obj->renderConditionRowFromParam($selectedParams, $conditionId);
		wp_die();
	}
}

new Ajax();