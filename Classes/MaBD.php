<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
// Classe de connexion à une base de données
// S'inspire du pattern singleton pour n'ouvrir qu'une seule connexion
// Utilisation :
//    $bd = MaBD::getInstance(); // $bd est un objet PDO
class MaBD {

   static private $pdo = null; // Le singleton

   // Obenir le singleton
   static function getInstance() {
      if (self::$pdo == null) {
         $dsn = "mysql:host=ugogaldu.mysql.db;dbname=ugogaldu;charset=utf8";
         self::$pdo = new PDO($dsn, "ugogaldu", "Nitendo3ds261");
      }
      return self::$pdo;
   }
}

