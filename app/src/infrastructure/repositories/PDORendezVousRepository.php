<?php

namespace toubilib\infra\repositories;


use DateTime;
use Exception;
use Faker\Core\Uuid;
use PDO;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\infra\repositories\interface\RendezVousRepositoryInterface;

class PDORendezVousRepository implements RendezVousRepositoryInterface {


    private PDO $rdv_pdo;

    public function __construct(PDO $rdv_pdo) {
        $this->rdv_pdo = $rdv_pdo;
    }

    public function getCreneauxOccupees(string $debut, string $fin, string $praticien_id): array {
        // FORMAT DATE : YYYY-MM-DD
        if (!$this->estDateValide($debut)) {
            throw new Exception("format date de début invalide");
        }

        if ($this->estDateValide($fin)) {
            if (strlen($fin) <= 10) {
                $fin = $fin . " 23:59:59";
            }
        } else {
            throw new Exception("format date de fin invalide");
        }

        try {
            $query = $this->rdv_pdo->query("SELECT date_heure_debut, duree, date_heure_fin, motif_visite FROM rdv WHERE date_heure_debut < '$fin' AND date_heure_fin > '$debut' AND praticien_id = '$praticien_id'");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la reception des RDV.");
        }
    }

    public function getRDV(string $id_prat, string $id_rdv): array {
        try {
            $query = $this->rdv_pdo->query("SELECT date_heure_debut, duree, date_heure_fin, motif_visite FROM rdv WHERE id = '$id_rdv' AND praticien_id = '$id_prat'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($res) > 1) {
                throw new Exception("Erreur : plusieurs rendez vous ont ete trouves.");
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

    public function createRdv($dto) : void
    {
        try {
            $id = \Ramsey\Uuid\Uuid::uuid4();
            $query = $this->rdv_pdo->query("INSERT INTO rdv (id, patient_id, praticien_id, date_heure_debut, date_heure_fin, duree, motif_visite)
                      VALUES ('$id', '$dto->patient_id', '$dto->praticien_id', '$dto->date_heure_debut', '$dto->date_heure_fin',
                      '$dto->duree', '$dto->motif_visite')");
        } catch (\Throwable) {
            throw new Exception("Erreur lors de la creation du rendez vous.");
        }
        
    }
}