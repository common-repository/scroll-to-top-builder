<?php
namespace ystp;

class Checker {
	private $obj;
	
	public function setObj($obj) {
		$this->obj = $obj;
	}
	
	public function getObj() {
		return $this->obj;
	}
	
	public function isAllow() {
		$status = true;

		$obj = $this->getObj();
		
		if(empty($obj)) {
			return false;
		}

		$isActive = $this->isActive();
		if(!$isActive) {
			return $isActive;
		}

		$status = $this->checkConditions();

		if(YSTP_PKG_VERSION > YSTP_FREE_VERSION && $status) {
			require_once YSTP_CLASSES_PATH.'CheckerPro.php';
			$obj = new CheckerPro();
			$obj->setCheckerObj($this);
			$isAllow = $obj->allowToLoad();
			
			if(!$isAllow) {
				return $isAllow;
			}
		}

		return $status;
	}
	
	private function isActive() {
		$obj = $this->getObj();
		$id = $obj->getId();
		
		return Scroll::isActivePost($id);
	}

	private function checkConditions() {
		$settings = $this->getObj()->getOptionValue('ystp-display-settings');

		if(empty($settings)) {
			return false;
		}
		$devideSettings = $this->devideSettings($settings);
		if(!empty($devideSettings['forbidden'])) {
			$status = $this->isSatisfyForConditions($devideSettings['forbidden']);
			if($status) {
				return !$status;
			}
		}

		if(!empty($devideSettings['permissive'])) {
			$status = $this->isSatisfyForConditions($devideSettings['permissive']);
			if($status) {
				return $status;
			}
		}

		return false;
	}

	public function devideSettings($settings) {
		$devidedData = array();
		foreach ($settings as $key => $setting) {
			if(empty($setting['key2'])) {
				continue;
			}
			if($setting['key2'] == 'is') {
				$devidedData['permissive'][] = $setting;
			}
			if($setting['key2'] == 'isnot') {
				$devidedData['forbidden'][] = $setting;
			}
		}

		return $devidedData;
	}

	private function isSatisfyForConditions($settings) {
		$status = false;
		if(empty($settings)) {
			return $status;
		}
		foreach ($settings as $setting) {
			$currentStatus = $this->isSatisfyForCondition($setting);
			if($currentStatus) {
				$status = $currentStatus;
				break;
			}
		}

		return $status;
	}

	private function isSatisfyForCondition($setting) {
		if(empty($setting['key1'])) {
			return false;
		}
		$key = $setting['key1'];
		$postId = get_queried_object_id();
		if($key == 'everywhere') {
			return true;
		}
        if(strpos($key, 'all_') == 0) {
            $currentPostType = get_post_type($postId);
            if ('all_'.$currentPostType == $key) {
                return true;
            }
        }
		if(strpos($key, 'selected_') == 0) {
			$selectTargetIds = array_keys($setting['key3']);
			if(in_array($postId, $selectTargetIds)) {
				return true;
			}
		}

		return false;
	}
}