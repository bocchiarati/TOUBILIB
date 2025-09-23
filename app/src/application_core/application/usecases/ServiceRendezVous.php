<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\api\dtos\InputRdvDTO;
use toubilib\api\dtos\InputRendezVousDTO;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    private RendezVousRepositoryInterface $rendezVousRepository;

    public function __construct(RendezVousRepositoryInterface $rendezVousRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function listerRDV(string $debut, string $fin, string $praticien_id): array {
        return $this->praticienRepository->getCreneauxOccupees($debut, $fin, $praticien_id);
    }

    public function getRDV($id_prat, $id_rdv): array {
        return $this->praticienRepository->getRDV($id_prat, $id_rdv);
    }

    public function creerRendezVous(InputRendezVousDTO $dto) {
        return $this->rendezVousRepository->createRdv($dto);
    }
}