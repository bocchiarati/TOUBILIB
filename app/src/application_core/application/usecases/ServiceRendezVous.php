<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\api\dtos\InputRendezVousDTO;
use toubilib\infra\repositories\interface\RendezVousRepositoryInterface;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    private RendezVousRepositoryInterface $rendezVousRepository;

    public function __construct(RendezVousRepositoryInterface $rendezVousRepository)
    {
        $this->rendezVousRepository = $rendezVousRepository;
    }

    public function listerRDV(string $debut, string $fin, string $praticien_id): array {
        return $this->rendezVousRepository->getCreneauxOccupees($debut, $fin, $praticien_id);
    }

    public function getRDV($id_prat, $id_rdv): array {
        return $this->rendezVousRepository->getRDV($id_prat, $id_rdv);
    }

    public function creerRendezVous(InputRendezVousDTO $dto) {
        return $this->rendezVousRepository->createRdv($dto);
    }
}