<?php
namespace ystp;

class ScrollModel {
    private static $data = array();

    private function __construct() {
    }

    public static function getDataById($postId) {
        if (!isset(self::$data[$postId])) {
            self::$data[$postId] = Scroll::getPostSavedData($postId);
        }

        return self::$data[$postId];
    }
}
