<?php

namespace toubilib\core\application\usecases\interfaces;


use toubilib\api\dtos\InputRendezVousDTO;

interface ServiceRendezVousInterface {
    public function listerRDV(string $praticien_id, ?string $debut = null, ?string $fin = null): array;
    public function getRDV($id_prat, $id_rdv): array;
    public function creerRendezVous(InputRendezVousDTO $dto): array;
    public function annulerRendezVous($id_rdv);
}