<?php
// Classe représentant l'objet Administrateur
class Administrateur {

    public $id;
    public $login;
    public $mdp;

    public function __construct($id, $login, $mdp) {
        $this->$id = $id;
        $this->$login = $login;
        $this->$mdp = $mdp;
    }

    public function __tostring() {
        return "$this->id : $this->login $this->mdp";
    }

}