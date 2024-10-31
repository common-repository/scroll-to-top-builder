<?php
namespace ystp;
use \YstpOptionsConfig;

abstract class Scroll {

	private $id;
	private $type;
	private $displayName;
	private $title;
	private $savedData;
	private $sanitizedData;
	private $shortCodeArgs;
	private $shortCodeContent;

	abstract protected function getViewContent();

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

	public function setDisplayName($displayName) {
		$this->displayName = $displayName;
	}

	public function getDisplayName() {
		if(empty($this->displayName)) {
			$type = $this->getType();
			return ucfirst($type);
		}
		return $this->displayName;
	}
	
	public function getTypeTitle() {
		$type = $this->getType();
		global $YSTP_TYPES;
		$titles = $YSTP_TYPES['titles'];
		
		$typeTitle = (isset($titles[$type])) ? $titles[$type] : __('Unknown Type', YSTP_TEXT_DOMAIN);
		
		return $typeTitle;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setShortCodeContent($shortCodeContent) {
		$this->shortCodeContent = $shortCodeContent;
	}

	public function getShortCodeContent() {
		return $this->shortCodeContent;
	}

	public function setShortCodeArgs($shortCodeArgs) {
		$this->shortCodeArgs = $shortCodeArgs;
	}

	public function getShortCodeArgs() {
		return $this->shortCodeArgs;
	}

	public function setSavedData($savedData) {
		$this->savedData = $savedData;
	}

	public function getSavedData() {
		return $this->savedData;
	}

	public function insertIntoSanitizedData($sanitizedData) {
		if (!empty($sanitizedData)) {
			$this->sanitizedData[$sanitizedData['name']] = $sanitizedData['value'];
		}
	}

	public function getSanitizedData() {
		return $this->sanitizedData;
	}

	public static function create($data = array()) {
		$obj = new static();
		$id = $data['ystp-post-id'];
		$obj->setId($id);

		// set up apply filter
		YstpOptionsConfig::optionsValues();
		foreach ($data as $name => $value) {
			$defaultData = $obj->getDefaultDataByName($name);
			if (empty($defaultData['type'])) {
				$defaultData['type'] = 'string';
			}
			$obj->saveConditionSettings($data);
			$sanitizedValue = $obj->sanitizeValueByType($value, $defaultData['type']);
			$obj->insertIntoSanitizedData(array('name' => $name,'value' => $sanitizedValue));
		}

		$result = $obj->save();
	}

	public function save() {
		$options = $this->getSanitizedData();
		$options = apply_filters('ystpSavedOptions', $options);
		$postId = $this->getId();
		
		update_post_meta($postId, 'ystp_options', $options);
	}

	private function saveConditionSettings($data) {
		if(empty($data['ystp-display-settings'])) {
			return '';
		}
		$postId = $this->getId();
		$settings = $data['ystp-display-settings'];

		$obj = new DisplayConditionBuilder();
		$obj->setSavedData($settings);
		$settings = $obj->filterForSave();

		update_post_meta($postId, 'ystp-display-settings', $settings);
	}

	public function sanitizeValueByType($value, $type) {
		switch ($type) {
			case 'string':
			case 'number':
				$sanitizedValue = sanitize_text_field($value);
				break;
			case 'html':
				$sanitizedValue = $value;
				break;
			case 'array':
				$sanitizedValue = $this->recursiveSanitizeTextField($value);
				break;
			case 'ystp':
				$sanitizedValue = $value;
				break;
			case 'email':
				$sanitizedValue = sanitize_email($value);
				break;
			case "checkbox":
				$sanitizedValue = sanitize_text_field($value);
				break;
			default:
				$sanitizedValue = sanitize_text_field($value);
				break;
		}

		return $sanitizedValue;
	}

	public function recursiveSanitizeTextField($array) {
		if (!is_array($array)) {
			return $array;
		}

		foreach ($array as $key => &$value) {
			if (is_array($value)) {
				$value = $this->recursiveSanitizeTextField($value);
			}
			else {
				/*get simple field type and do sensitization*/
				$defaultData = $this->getDefaultDataByName($key);
				if (empty($defaultData['type'])) {
					$defaultData['type'] = 'string';
				}
				$value = $this->sanitizeValueByType($value, $defaultData['type']);
			}
		}

		return $array;
	}

	public function getDefaultDataByName($optionName) {
		global $YSTP_OPTIONS;

		foreach ($YSTP_OPTIONS as $option) {
			if ($option['name'] == $optionName) {
				return $option;
			}
		}

		return array();
	}

	public function getDefaultValue($optionName) {

		if (empty($optionName)) {
			return '';
		}

		$defaultData = $this->getDefaultDataByName($optionName);

		if (empty($defaultData['defaultValue'])) {
			return '';
		}

		return $defaultData['defaultValue'];
	}

	public function isAllowOption($optionName) {
		if(YSTP_PKG_VERSION == YSTP_FREE_VERSION) {
			return true;
		}
		$defaultData = $this->getDefaultDataByName($optionName);

		if(empty($defaultData['available'])) {
			return true;
		}

		return YSTP_PKG_VERSION >= $defaultData['available'];
	}

	public static function parseScrollDataFromData($data) {
		$cdData = array();

		if(empty($data)) {
			return $cdData;
		}

		foreach ($data as $key => $value) {
			if (strpos($key, 'ystp') === 0) {
				$cdData[$key] = $value;
			}
		}

		return $cdData;
	}

	public static function getClassNameScrollType($type) {
		$typeName = ucfirst(strtolower($type));
		$className = $typeName.'ScrollToTop';

		return $className;
	}

	public static function getTypePathFormScrollType($type) {
		global $YSTP_TYPES;
		$typePath = '';

		if (!empty($YSTP_TYPES['typePath'][$type])) {
			$typePath = $YSTP_TYPES['typePath'][$type];
		}

		return $typePath;
	}

	/**
	 * Get option value from name
	 * @since 1.0.0
	 *
	 * @param string $optionName
	 * @param bool $forceDefaultValue
	 * @return string
	 */
	public function getOptionValue($optionName, $forceDefaultValue = false) {
		$savedData = ScrollModel::getDataById($this->getId());
		$this->setSavedData($savedData);

		return $this->getOptionValueFromSavedData($optionName, $forceDefaultValue);
	}

	public function getOptionValueFromSavedData($optionName, $forceDefaultValue = false) {
		
		$defaultData = $this->getDefaultDataByName($optionName);
		$savedData = $this->getSavedData();
		
		$optionValue = null;

		if (empty($defaultData['type'])) {
			$defaultData['type'] = 'string';
		}

		if (!empty($savedData)) { //edit mode
			if (isset($savedData[$optionName])) { //option exists in the database
				$optionValue = $savedData[$optionName];
			}
			/* if it's a checkbox, it may not exist in the db
			 * if we don't care about it's existence, return empty string
			 * otherwise, go for it's default value
			 */
			else if ($defaultData['type'] == 'checkbox' && !$forceDefaultValue) {
				$optionValue = '';
			}
		}

		if (($optionValue === null && !empty($defaultData['defaultValue'])) || ($defaultData['type'] == 'number' && !isset($optionValue))) {
			$optionValue = $defaultData['defaultValue'];
		}

		if ($defaultData['type'] == 'checkbox') {
			$optionValue = $this->boolToChecked($optionValue);
		}

		if(isset($defaultData['ver']) && $defaultData['ver'] > YSTP_PKG_VERSION) {
			if (empty($defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
			else if (!in_array($optionValue, $defaultData['allow'])) {
				return $defaultData['defaultValue'];
			}
		}

		return $optionValue;
	}

	public static function getPostSavedData($postId) {
		$savedData = get_post_meta($postId, 'ystp_options');
		
		if (empty($savedData)) {
			return $savedData;
		}
		$savedData = $savedData[0];
		$displaySettings = self::getDisplaySettings($postId);
		if(!empty($displaySettings)) {
			$savedData['ystp-display-settings'] = $displaySettings;
		}

		return $savedData;
	}

	public static function getDisplaySettings($postId) {
		$savedData = get_post_meta($postId, 'ystp-display-settings', true);
		
		return $savedData;
	}

	public static function find($id) {
		$options = ScrollModel::getDataById($id);
		
		if(empty($options)) {
			return false;
		}
		$type = $options['ystp-type'];

		$typePath = self::getTypePathFormScrollType($type);
		$className = self::getClassNameScrollType($type);

		if (!file_exists($typePath.$className.'.php')) {
			return false;
		}

		require_once($typePath.$className.'.php');
		$className = __NAMESPACE__.'\\'.$className;
		$postTitle = get_the_title($id);

		$typeObj = new $className();
		$typeObj->setId($id);
		$typeObj->setType($type);
		$typeObj->setTitle($postTitle);
		$typeObj->setSavedData($options);

		return $typeObj;
	}

	public static function isActivePost($postId) {
		$enabled = !get_post_meta($postId, 'ystp_enable', true);
		$postStatus = get_post_status($postId);
		
		return ($enabled && $postStatus == 'publish');
	}

	public function boolToChecked($var) {
		return ($var ? 'checked' : '');
	}

	public static function shapeIdTitleData($scrolls) {
		$idTitle = array();

		if(empty($scrolls)) {
			return $idTitle;
		}

		foreach ($scrolls as $scroll) {
			$title = $scroll->getTitle();

			if(empty($title)) {
				$title = __('(no title)', YSTP_TEXT_DOMAIN);
			}

			$idTitle[$scroll->getId()] = $title .' - '. $scroll->getTypeTitle();
		}

		return $idTitle;
	}

	/**
	 * Changing default options form changing options by name
	 *
	 * @since 1.0.0
	 *
	 * @param array $defaultOptions
	 * @param array $changingOptions
	 *
	 * @return array $defaultOptions
	 */
	public function changeDefaultOptionsByNames($defaultOptions, $changingOptions)
	{
		if (empty($defaultOptions) || empty($changingOptions)) {
			return $defaultOptions;
		}
		$changingOptionsNames = array_keys($changingOptions);
		
		foreach ($defaultOptions as $key => $defaultOption) {
			$defaultOptionName = $defaultOption['name'];
			if (in_array($defaultOptionName, $changingOptionsNames)) {
				$defaultOptions[$key] = $changingOptions[$defaultOptionName];
			}
		}
		
		return $defaultOptions;
	}
	
	/**
	 * Returns separate scroll types Free or Pro
	 *
	 * @since 2.5.6
	 *
	 * @return array $scrollTypesObj
	 */
	public static function getScrollTypes()
	{
		global $YSTP_TYPES;
		$scrollTypesObj = array();
		$scrollTypes = $YSTP_TYPES['typeName'];
		
		foreach ($scrollTypes as $scrollType => $level) {
			
			if (empty($level)) {
				$level = YSTP_PKG_VERSION;
			}
			
			$scrollTypeObj = new ScrollType();
			$scrollTypeObj->setName($scrollType);
			$scrollTypeObj->setAccessLevel($level);
			
			if (YSTP_PKG_VERSION >= $level) {
				$scrollTypeObj->setAvailable(true);
			}
			$scrollTypesObj[] = $scrollTypeObj;
		}
		
		return $scrollTypesObj;
	}

	private function includeStyles() {
        ScriptsIncluder::registerStyle('generalStyle.css');
        ScriptsIncluder::enqueueStyle('generalStyle.css');
    }

	public function getCurrentStyles() {
	    $this->includeStyles();
		$position = $this->getOptionValue('ystp-button-position');
		$marginX = $this->getOptionValue('ystp-margin-x');
		$marginY = $this->getOptionValue('ystp-margin-y');
		$opacity = $this->getOptionValue('ystp-scroll-opacity');
	   
		$stylesArray = array(
			'position' => 'fixed',
			'cursor' => 'pointer',
			'z-index' => $this->getOptionValue('ystp-z-index')
		);

		if($position == 'bottom-right') {
			$stylesArray['bottom'] = (int)$marginY.'px';
			$stylesArray['right'] = (int)$marginX.'px';
		}
		if($position == 'bottom-left') {
			$stylesArray['bottom'] = (int)$marginY.'px';
			$stylesArray['left'] = (int)$marginX.'px';
		}
		if($position == 'top-left') {
			$stylesArray['top'] = (int)$marginY.'px';
			$stylesArray['left'] = (int)$marginX.'px';
		}
		if($position == 'top-right') {
			$stylesArray['top'] = (int)$marginY.'px';
			$stylesArray['right'] = (int)$marginX.'px';
		}

        if (isset($opacity)) {
            $stylesArray['opacity'] = $opacity;
        }

		return AdminHelper::createStyleAttrs($stylesArray);
	}
	
}