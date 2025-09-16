<?php

namespace toubilib\infra\repositories;



use App\application_core\application\exceptions\DatabaseException;
use PDO;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class PDOPraticienRepository implements PraticienRepositoryInterface {


    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getPraticiens() : array {
        try {
            $query = $this->pdo->query("SELECT praticien.id, nom, prenom, ville, email, specialite.libelle as specialite FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            //todo
        }
    }

    public function getPraticien($id): array {
        try {
            $query = $this->pdo->query("SELECT praticien.nom, praticien.prenom, specialite.libelle as specialite, praticien.email, praticien.telephone FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id
                                          WHERE praticien.id = '$id'");

            $moyens_paiement = $this->pdo->query("SELECT moyen_paiement.libelle FROM moyen_paiement
                                           INNER JOIN praticien2moyen ON moyen_paiement.id = praticien2moyen.moyen_id
                                           WHERE praticien2moyen.praticien_id = '$id'");

            $motifs_visite = $this->pdo->query("SELECT motif_visite.libelle as motif_visite FROM motif_visite
                                           INNER JOIN praticien2motif ON motif_visite.id = praticien2motif.motif_id
                                           WHERE praticien2motif.praticien_id = '$id'");
            $array = $query->fetchAll(PDO::FETCH_ASSOC);
            $array[0]['moyens_paiement'] = $moyens_paiement->fetchAll(PDO::FETCH_ASSOC);
            $array[0]['motifs_visite'] = $motifs_visite->fetchAll(PDO::FETCH_ASSOC);

            return $array;
        } catch (\Throwable $e) {
            //todo
        }
    }
}