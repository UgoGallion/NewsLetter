<?php

class AdministrateurDAO extends DAO {

    // Récupération d'un objet Administrateur dont on donne l'identifiant (supposé fiable)
    public function getOne($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Administrateurs WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Administrateur($row['id'], $row['login'], $row['mdp']);
    }

    // Récupération de tous les objets dans une table
    public function getAll() {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM Administrateurs");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new Administrateur($row['id'], $row['login'], $row['mdp']);
        return $res;
    }

    // Sauvegarde de l'objet $obj :
    //     $obj->id == UNKNOWN_ID ==> INSERT
    //     $obj->id != UNKNOWN_ID ==> UPDATE
    public function save($obj) {
        if ($obj->id == DAO::UNKNOWN_ID) {
            $stmt =  $this->pdo->prepare("INSERT INTO Administrateurs (login, mdp)" . " VALUES (?,?)");
            $res = $stmt->execute([$obj->login, $obj->mdp]);
            $obj->id = $this->pdo->lastInsertId();
        } else {
            $stmt = $this->pdo->prepare("UPDATE Administrateurs SET login=:login, mdp=:mdp" . " WHERE id=:id");
            $res = $stmt->execute(['id' => $obj->id, 'login' => $obj->login, 'mdp' => $obj->mdp]);
        }
        return $res;
    }

    // Effacement de l'objet $obj (DELETE)
    public function delete($obj) {
        $stmt = $this->pdo->prepare("DELETE FROM Administrateurs WHERE id = ?");
        return $stmt->execute([$obj->id]);
    }
    
    /**
     * Check if login success.
     */
    public function check($login,$mdp){
        $stmt = $this->pdo->prepare("SELECT * FROM Administrateurs WHERE login=? AND mdp=?");
        $stmt->execute(array($login, $mdp));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($row['id'])) {
            return null;
        }
        return new Administrateur($row['id'], $row['login'], $row['mdp']);

    }
}