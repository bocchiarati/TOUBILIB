<?php

namespace toubilib\core\domain\entities\rdv;

use Exception;

class RendezVous {
    private string $id;
    private string $praticien_id;
    private string $patient_id;
    private string $patient_email;
    private string $date_heure_debut;
    private string $date_heure_fin;
    private string $motif_visite;
    private int $duree;
    private int $status;

    /**
     * @throws Exception
     */
    public function __get(string $property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new Exception("La propriété '$property' n'existe pas.");
    }
}