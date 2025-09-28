<?php

namespace toubilib\core\application\usecases\interfaces;


use toubilib\api\dtos\InputRendezVousDTO;
use toubilib\api\dtos\RendezVousDTO;

interface ServiceRendezVousInterface {
    public function listerRDV(string $praticien_id, ?string $debut = null, ?string $fin = null): array;
    public function getRDV($id_rdv): RendezVousDTO;
    public function creerRendezVous(InputRendezVousDTO $dto): array;
    public function annulerRendezVous($id_rdv): array;
}