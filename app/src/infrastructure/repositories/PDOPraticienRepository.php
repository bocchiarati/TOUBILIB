<?php

namespace toubilib\infra\repositories;



use PDO;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class PDOPraticienRepository implements PraticienRepositoryInterface {


    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getPraticiens() : array {
        $query = $this->pdo->query("SELECT id, nom, prenom, ville, email FROM praticien");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}