<?php

namespace toubilib\infra\repositories;



use PDO;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class PDOPraticienRepository implements PraticienRepositoryInterface {


    private PDO $prati_pdo;
    private PDO $rdv_pdo;

    public function __construct(PDO $prati_pdo, PDO $rdv_pdo) {
        $this->prati_pdo = $prati_pdo;
        $this->rdv_pdo = $rdv_pdo;
    }

    public function getPraticiens() : array {
        $query = $this->prati_pdo->query("SELECT praticien.id, nom, prenom, ville, email, specialite.libelle as specialite FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}