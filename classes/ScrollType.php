<?php
namespace ystp;

class ScrollType {
    private $available = false;
    private $name = '';
    private $accessLevel = YSTP_FREE_VERSION;

    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }

    public function setAvailable($available) {
        $this->available = $available;
    }

    public function isAvailable() {
        return $this->available;
    }

    public function setAccessLevel($accessLevel) {
        $this->accessLevel = $accessLevel;
    }

    public function getAccessLevel() {
        return $this->accessLevel;
    }
}