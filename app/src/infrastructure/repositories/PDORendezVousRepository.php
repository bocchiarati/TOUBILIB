<?php

namespace toubilib\infra\repositories;


use DateTime;
use DI\NotFoundException;
use Exception;
use PDO;
use Slim\Exception\HttpInternalServerErrorException;
use toubilib\core\domain\entities\rdv\RendezVous;
use toubilib\core\exceptions\CreneauException;
use toubilib\core\exceptions\EntityNotFoundException;
use toubilib\infra\repositories\interface\RendezVousRepositoryInterface;

class PDORendezVousRepository implements RendezVousRepositoryInterface {


    private PDO $rdv_pdo;

    public function __construct(PDO $rdv_pdo) {
        $this->rdv_pdo = $rdv_pdo;
    }

    public function getCreneauxOccupes(string $debut, string $fin, string $praticien_id): array {
        // FORMAT DATE : YYYY-MM-DD
        if (!$this->estDateValide($debut)) {
            throw new CreneauException("Le format de la date de debut est invalide.");
        }

        if ($this->estDateValide($fin)) {
            if (strlen($fin) <= 10) {
                $fin = $fin . " 23:59:59";
            }
        } else {
            throw new CreneauException("Le format de la date de fin est invalide.");
        }

        try {
            $query = $this->rdv_pdo->query("SELECT * FROM rdv WHERE date_heure_debut < '$fin' AND date_heure_fin > '$debut' AND praticien_id = '$praticien_id'");
            $array = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (HttpInternalServerErrorException) {
            //500
            throw new Exception("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable) {
            throw new Exception("Erreur lors de la reception des rendez-vous.");
        }
        $res = [];
        foreach ($array as $rdv) {
            $res[] = new RendezVous(
                id: $rdv['id'],
                praticien_id: $rdv['praticien_id'],
                patient_id: $rdv['patient_id'],
                status: (int)$rdv['status'],
                duree: (int)$rdv['duree'],
                date_heure_fin: $rdv['date_heure_fin'],
                motif_visite: $rdv['motif_visite'],
                date_heure_debut: $rdv['date_heure_debut'],
                patient_email: $rdv['patient_email'],
                date_creation: $rdv['date_creation']
            );
        }
        return $res;
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function getRDV(string $id_prat, string $id_rdv): RendezVous {
        try {
            $query = $this->rdv_pdo->query("SELECT * FROM rdv WHERE id = '$id_rdv' AND praticien_id = '$id_prat'");
        } catch (HttpInternalServerErrorException) {
            //500
            throw new Exception("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable) {
            throw new Exception("Erreur lors de la reception du rendez-vous.");
        }

        $rdv = $query->fetch(PDO::FETCH_ASSOC);
        if (!$rdv) {
            throw new EntityNotFoundException("Le rendez-vous ayant pour id ".$id_rdv." avec le praticien ayant pour id ".$id_prat." n'existe pas.", "RDV");
        } else {
            return new RendezVous(
                id: $rdv['id'],
                praticien_id: $rdv['praticien_id'],
                patient_id: $rdv['patient_id'],
                status: (int) $rdv['status'],
                duree: (int) $rdv['duree'],
                date_heure_fin: $rdv['date_heure_fin'],
                motif_visite: $rdv['motif_visite'],
                date_heure_debut: $rdv['date_heure_debut'],
                patient_email: $rdv['patient_email'],
                date_creation: $rdv['date_creation']
            );
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
            $this->rdv_pdo->query("INSERT INTO rdv (id, patient_id, praticien_id, date_heure_debut, date_heure_fin, duree, motif_visite)
                      VALUES ('$id', '$dto->patient_id', '$dto->praticien_id', '$dto->date_heure_debut', '$dto->date_heure_fin',
                      '$dto->duree', '$dto->motif_visite')");
        } catch (HttpInternalServerErrorException) {
            //500
            throw new Exception("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable $e) {
            throw new Exception("Erreur lors de la création du rendez-vous.");
        }
        
    }

    public function annulerRdv($id_rdv) {
        try {
            $this->rdv_pdo->query("UPDATE rdv SET status = 1 WHERE id = '$id_rdv'");
        } catch (HttpInternalServerErrorException) {
            //500
            throw new HttpInternalServerErrorException("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable) {
            throw new Exception("Erreur lors de l'annulation du rendez-vous.");
        }

    }
}