<?php

namespace toubilib\infra\repositories;

use Exception;
use PDO;
use PhpParser\Node\Expr\List_;
use toubilib\core\domain\entities\praticien\Praticien;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class PDOPraticienRepository implements PraticienRepositoryInterface {


    private PDO $prati_pdo;

    public function __construct(PDO $prati_pdo) {
        $this->prati_pdo = $prati_pdo;
    }

    public function getPraticiens() : array {
        try {
            $query = $this->prati_pdo->query("SELECT praticien.id, nom, prenom, ville, email, specialite.libelle, telephone, email as specialite FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id");
            $array = $query->fetchAll(PDO::FETCH_ASSOC);
            $res = [];
            foreach ($array as $praticien) {
                $res[] = new Praticien(
                    id: $praticien['id'],
                    nom: $praticien['nom'],
                    prenom: $praticien['prenom'],
                    ville: $praticien['ville'],
                    email: $praticien['email'],
                    telephone: $praticien['telephone'],
                    specialite: $praticien['specialite']
                );
            }
            return $res;
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception des praticiens.");
        }
    }

    public function getPraticien($id): Praticien {
        try {
            $query = $this->prati_pdo->query("SELECT praticien.id, praticien.nom, praticien.ville, praticien.email, praticien.prenom, specialite.libelle as specialite, praticien.email, praticien.telephone FROM praticien
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

        return new Praticien(
            id: $array[0]['id'],
            nom: $array[0]['nom'],
            prenom: $array[0]['prenom'],
            ville: $array[0]['ville'],
            email: $array[0]['email'],
            telephone: $array[0]['telephone'],
            specialite: $array[0]['specialite']
        );
    }

    private function getMotifsVisite($id) : array {
        try {
            $motifs_visite = $this->prati_pdo->query("SELECT motif_visite.libelle as motif_visite FROM motif_visite
                                           INNER JOIN praticien2motif ON motif_visite.id = praticien2motif.motif_id
                                           WHERE praticien2motif.praticien_id = '$id'");
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception des motifs de visite.");
        }

        $res = $motifs_visite->fetchAll(PDO::FETCH_ASSOC);
        return array_column($res, "motif_visite");
    }

    private function getMoyenPaiement($id) : array {
        try {
            $moyens_paiement = $this->prati_pdo->query("SELECT moyen_paiement.libelle as moyen_paiement FROM moyen_paiement
                                           INNER JOIN praticien2moyen ON moyen_paiement.id = praticien2moyen.moyen_id
                                           WHERE praticien2moyen.praticien_id = '$id'");
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception des moyens de paiement.");
        }

        $res = $moyens_paiement->fetchAll(PDO::FETCH_ASSOC);
        return array_column($res, "moyen_paiement");
    }
}