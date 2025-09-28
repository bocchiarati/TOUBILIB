<?php

namespace toubilib\infra\repositories\interface;

use toubilib\core\domain\entities\rdv\RendezVous;

interface RendezVousRepositoryInterface {
    public function getCreneauxOccupees(string $debut, string $fin, string $praticien_id) : array;
    public function getRDV(string $id_rdv) : RendezVous;
    public function createRdv($dto) : void;
    public function annulerRdv($id_rdv);
}