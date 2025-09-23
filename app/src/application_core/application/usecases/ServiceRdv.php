<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\usecases\interfaces\ServiceRdvInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\api\dtos\InputRdvDTO;

class ServiceRdv implements ServiceRdvInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function listerRDV(string $debut, string $fin, string $praticien_id): array {
        return $this->praticienRepository->getCreneauxOccupees($debut, $fin, $praticien_id);
    }

    public function getRDV($id_prat, $id_rdv): array {
        return $this->praticienRepository->getRDV($id_prat, $id_rdv);
    }

    public function creerRendezVous(InputRdvDTO $dto) {

    }
}