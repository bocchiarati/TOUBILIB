<?php

namespace toubilib\infra\repositories;

use Exception;
use PDO;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class PDOPraticienRepository implements PraticienRepositoryInterface {


    private PDO $prati_pdo;

    public function __construct(PDO $prati_pdo) {
        $this->prati_pdo = $prati_pdo;
    }

    public function getPraticiens() : array {
        try {
            $query = $this->prati_pdo->query("SELECT praticien.id, nom, prenom, ville, email, specialite.libelle as specialite FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception des praticiens.");
        }
    }

    public function getPraticien($id): array {
        try {
            $query = $this->prati_pdo->query("SELECT praticien.nom, praticien.prenom, specialite.libelle as specialite, praticien.email, praticien.telephone FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id
                                          WHERE praticien.id = '$id'");
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception du praticien.");
        }

        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        try {
            $array[0]['moyens_paiement'] = $this->getMoyenPaiement($id);
        } catch (\Exception $e) {
            throw new Exception("Erreur lors de la reception des moyens de paiement.");
        }

        try {
            $array[0]['motifs_visite'] = $this->getMotifsVisite($id);
        } catch (\Exception $e) {
            throw new Exception("Erreur lors de la reception des motifs de visite.");
        }
        return $array;
    }

    private function getMotifsVisite($id) : array {
        try {
            $motifs_visite = $this->prati_pdo->query("SELECT motif_visite.libelle as motif_visite FROM motif_visite
                                           INNER JOIN praticien2motif ON motif_visite.id = praticien2motif.motif_id
                                           WHERE praticien2motif.praticien_id = '$id'");
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception des motifs de visite.");
        }

        return $motifs_visite->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getMoyenPaiement($id) : array {
        try {
            $moyens_paiement = $this->prati_pdo->query("SELECT moyen_paiement.libelle FROM moyen_paiement
                                           INNER JOIN praticien2moyen ON moyen_paiement.id = praticien2moyen.moyen_id
                                           WHERE praticien2moyen.praticien_id = '$id'");
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception des moyens de paiement.");
        }

        return $moyens_paiement->fetchAll(PDO::FETCH_ASSOC);
    }
}