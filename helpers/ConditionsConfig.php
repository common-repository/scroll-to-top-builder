<?php
namespace ystp;

class ConditionsConfig {

	public function __construct() {
		$this->init();
	}

	private function init() {
		$this->displaySettings();
	}

	private function displaySettings() {
		global $YSTP_DISPLAY_SETTINGS_CONFIG;
		$keys = array(
			'select_settings' => 'Select settings',
			'everywhere' => 'Everywhere',
			'all_post' => 'All posts',
			'selected_posts' => 'Select posts',
			'selected_pages' => 'Select pages',
			'all_page' => 'All pages'
		);

		$values = array(
			'key1' => $keys,
			'key2' => array('is' => 'Is', 'isnot' => 'Is not'),
			'selected_posts' => array(),
			'selected_pages' => array(),
			'everywhere' => array()
		);

		$attributes = array(
			'key1' => array(
				'label' => __('Select Conditions'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'class' => 'ystp-condition-select js-ystp-select js-conditions-param',
					'value' => ''
				)
			),
			'key2' => array(
				'label' => __('Select Conditions'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'class' => 'ystp-condition-select js-ystp-select',
					'value' => ''
				)
			),
			'selected_posts' => array(
				'label' => __('Select Post(s)'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'data-post-type' => 'post',
					'data-select-type' => 'ajax',
					'multiple' => 'multiple',
					'class' => 'ystp-condition-select js-ystp-select',
					'value' => ''
				)
			),
			'selected_pages' => array(
				'label' => __('Select Page(s)'),
				'fieldType' => 'select',
				'fieldAttributes' => array(
					'data-post-type' => 'page',
					'data-select-type' => 'ajax',
					'multiple' => 'multiple',
					'class' => 'ystp-condition-select js-ystp-select',
					'value' => ''
				)
			),
		);

		$keys = apply_filters('ystpConditionsDisplayKeys', $keys);
		$values = apply_filters('ystpConditionsDisplayValues', $values);
		$attributes = apply_filters('ystpConditionsDisplayAttributes', $attributes);

		$YSTP_DISPLAY_SETTINGS_CONFIG = array(
			'keys' => $keys,
			'values' => $values,
			'attributes' => $attributes
		);
	}

}

new ConditionsConfig();