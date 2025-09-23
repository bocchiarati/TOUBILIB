<?php

namespace toubilib\core\application\usecases\interfaces;


use toubilib\api\dtos\InputRendezVousDTO;

interface ServiceRendezVousInterface {
    public function listerRDV(string $debut, string $fin, string $praticien_id): array;
    public function getRDV($id_prat, $id_rdv): array;
    public function creerRendezVous(InputRendezVousDTO $dto);
}