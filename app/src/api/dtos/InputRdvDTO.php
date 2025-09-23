<?php

namespace toubilib\api\dtos;


use Exception;

class InputRdvDTO {
    private string $patient_id;
    private string $praticien_id;
    private string $date_heure_debut;
    private string $date_heure_fin;
    private int $duree;
    private string $motif_visite;

    public function __construct($patient_id, $praticien_id, $date_heure_debut, $date_heure_fin, $duree, $motif_visite) {
        $this->duree = $duree;
        $this->motif_visite = $motif_visite;
        $this->patient_id = $patient_id;
        $this->praticien_id = $praticien_id;
        $this->date_heure_debut = $date_heure_debut;
        $this->date_heure_fin = $date_heure_fin;
    }

    public function __get(string $property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new Exception("La propriété '$property' n'existe pas.");
    }
}