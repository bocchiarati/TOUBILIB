<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\usecases\interfaces\ServicePatientInterface;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;
use toubilib\api\dtos\InputRendezVousDTO;
use toubilib\infra\repositories\interface\RendezVousRepositoryInterface;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    private RendezVousRepositoryInterface $rendezVousRepository;
    private ServicePraticienInterface $servicePraticien;
    private ServicePatientInterface $servicePatient;

    public function __construct(RendezVousRepositoryInterface $rendezVousRepository, ServicePraticienInterface $servicePraticien, ServicePatientInterface $servicePatient)
    {
        $this->rendezVousRepository = $rendezVousRepository;
        $this->servicePraticien = $servicePraticien;
        $this->servicePatient = $servicePatient;
    }

    public function listerRDV(string $debut, string $fin, string $praticien_id): array {
        return $this->rendezVousRepository->getCreneauxOccupees($debut, $fin, $praticien_id);
    }

    public function getRDV($id_prat, $id_rdv): array {
        return $this->rendezVousRepository->getRDV($id_prat, $id_rdv);
    }

    public function creerRendezVous(InputRendezVousDTO $dto): array {
        try {
            $this->servicePraticien->getPraticien($dto->praticien_id);
            $this->servicePatient->getPatient($dto->patient_id);
            $this->rendezVousRepository->createRdv($dto);
            return [
                'success' => true,
                "message" => "RDV cree"
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => "RDV n'a pu etre cree"
            ];
        }
    }
}