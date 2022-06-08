<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

class Inscrit {
    public $id;
    public $email;

    public function __construct($id, $email) {
        $this->id = $id;
        $this->email = $email;
    }

    public function __tostring() {
        return "$this->id : $this->email";
    }

}