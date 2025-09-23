<?php

namespace toubilib\infra\repositories;


use DateTime;
use Exception;
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

            $moyens_paiement = $this->prati_pdo->query("SELECT moyen_paiement.libelle FROM moyen_paiement
                                           INNER JOIN praticien2moyen ON moyen_paiement.id = praticien2moyen.moyen_id
                                           WHERE praticien2moyen.praticien_id = '$id'");

            $motifs_visite = $this->prati_pdo->query("SELECT motif_visite.libelle as motif_visite FROM motif_visite
                                           INNER JOIN praticien2motif ON motif_visite.id = praticien2motif.motif_id
                                           WHERE praticien2motif.praticien_id = '$id'");
            $array = $query->fetchAll(PDO::FETCH_ASSOC);
            $array[0]['moyens_paiement'] = $moyens_paiement->fetchAll(PDO::FETCH_ASSOC);
            $array[0]['motifs_visite'] = $motifs_visite->fetchAll(PDO::FETCH_ASSOC);

            return $array;
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception du praticien.");
        }
    }

    public function getCreneauxOccupees(string $debut, string $fin, string $praticien_id): array {
        // FORMAT DATE : YYYY-MM-DD
        if(!$this->estDateValide($debut)){
            throw new Exception("format date de début invalide");
        }

        if($this->estDateValide($fin)) {
            if(strlen($fin) <= 10 ){
                $fin = $fin . " 23:59:59";
            }
        }

        else {
            throw new Exception("format date de fin invalide");
        }
        $query = $this->rdv_pdo->query("SELECT date_heure_debut, duree, date_heure_fin, motif_visite FROM rdv WHERE date_heure_debut BETWEEN '$debut' AND '$fin' AND praticien_id = '$praticien_id'");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRDV(string $id_prat, string $id_rdv): array {
        try {
            $query = $this->rdv_pdo->query("SELECT date_heure_debut, duree, date_heure_fin, motif_visite FROM rdv WHERE id = '$id_rdv' AND praticien_id = '$id_prat'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($res) > 1) {
                throw new Exception("Erreur : plusieurs rendez vous ont été trouvés.");
            } else {
                return $res[0];
            }
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception des rendez vous.");
        }
    }

    private function estDateValide($date) {
        // Essayer le format complet avec heure
        $formats = ['Y-m-d H:i:s', 'Y-m-d'];

        foreach ($formats as $format) {
            $d = DateTime::createFromFormat($format, $date);

            // Vérifie que la date a bien été créée, et qu'elle correspond exactement au format
            if ($d && $d->format($format) === $date) {
                return true;
            }
        }
        return false;
    }
}