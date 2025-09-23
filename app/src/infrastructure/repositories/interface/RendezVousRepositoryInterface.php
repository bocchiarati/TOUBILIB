<?php

namespace toubilib\infra\repositories\interface;

interface RendezVousRepositoryInterface {
    public function getCreneauxOccupees(string $debut, string $fin, string $praticien_id) : array;
    public function getRDV(string $id_prat, string $id_rdv) : array;
    public function createRdv($dto) : void;
}