<?php
namespace ystp;

class DisplayConditionBuilder extends ConditionBuilder {
	public function __construct() {
		global $YSTP_DISPLAY_SETTINGS_CONFIG;
		$configData = $YSTP_DISPLAY_SETTINGS_CONFIG;
		$this->setConfigData($configData);
		$this->setNameString('ystp-display-settings');
	}
}