<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

class InscritsDAO extends DAO {

    // Récupération d'un objet Contact dont on donne l'identifiant
    public function getOne($id) {
        // Ici on utilise une requête simple
        $stmt = $this->pdo->query("SELECT * FROM Inscrits WHERE id='$id'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Inscrit($row['id'], $row['email']);
    }

    // Récupération de tous les objets dans une table
    public function getAll() {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM Inscrits ORDER BY email");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Inscrit($row['id'], $row['email']);
        return $res;
    }

    /**
     * Sauvegarde l'utilisateur dans un registre SQL
     */
    public function save($obj) {
        if ($obj->id == DAO::UNKNOWN_ID) {
            //echo 'Id inconnu';
            // Requête préparée avec des paramètres anonymes (attention à l'ordre !)
            $stmt =  $this->pdo->prepare("INSERT INTO Inscrits (email)" . " VALUES (?)");
            $res = $stmt->execute([$obj->email]);
            $obj->id = $this->pdo->lastInsertId();
        } else {
           // echo 'Id connu';
            // Requête préparée avec des paramètres nommés (on ne peut pas utiliser de caractères
            // accentués dans les noms de paramètre).
            $stmt = $this->pdo->prepare("UPDATE Inscrits set email=:email " . " WHERE id=:id");
            $res = $stmt->execute(['id' => $obj->id, 'email' => $obj->email]); 
        }
        return $res;
    }

    // Effacement de l'objet $obj (DELETE)
    public function delete($obj) {
        // Requête préparée avec un bindParam
        // $stmt->bindParam(1, $id)
        $stmt = $this->pdo->prepare("DELETE FROM Inscrits WHERE id = ?");
        $stmt->bindParam(1, $obj->id);
        return $stmt->execute();
    }


}