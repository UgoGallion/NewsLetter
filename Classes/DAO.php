<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

/* Classe abstraite pour l'accès aux données d'une base
 * Hypothèse : une table contient toujours un champ id (integer autoincrémenté) qui est la clé primaire.
 */

abstract class DAO {
    const UNKNOWN_ID = -1; // Identifiant non déterminé
    protected $pdo; // Objet pdo pour l'accès à la table

    // Le constructeur reçoit l'objet PDO contenant la connexion
    public function __construct(PDO $connector) { $this->pdo = $connector; }

    // Récupération d'un objet dont on donne l'identifiant
    abstract public function getOne($id);

    // Récupération de tous les objets dans une table
    abstract public function getAll();

    // Sauvegarde de l'objet $obj :
    //     $obj->id == UNKNOWN_ID ==> INSERT
    //     $obj->id != UNKNOWN_ID ==> UPDATE
    abstract public function save($obj);

    // Effacement de l'objet $obj (DELETE)
    abstract public function delete($obj);
}