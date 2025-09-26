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

    public function listerRDV(string $praticien_id, ?string $debut = null, ?string $fin = null): array {
        if(is_null($debut)) {
            $debut = (new \DateTime())->setTime(8, 0)->format('Y-m-d H:i:s');
        }
        if(is_null($fin)) {
            $fin = (new \DateTime())->setTime(19,0)->format('Y-m-d H:i:s');
        }

        try {
            return $this->rendezVousRepository->getCreneauxOccupees($debut, $fin, $praticien_id);
        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de l'obtention de la liste des RDV (Service)\n" . $th->getMessage());
        }
    }

    public function getRDV($id_prat, $id_rdv): array {
        try {
            return $this->rendezVousRepository->getRDV($id_prat, $id_rdv);
        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de l'obtention du RDV (Service)\n" . $th->getMessage());
        }
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

    public function annulerRendezVous($id_rdv) {

    }
}