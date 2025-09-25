<?php

namespace toubilib\core\application\usecases;
use toubilib\core\application\usecases\interfaces\ServicePatientInterface;
use toubilib\infra\repositories\interface\PatientRepositoryInterface;

class ServicePatient implements ServicePatientInterface {
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function getPatient(string $id): array {
        return $this->patientRepository->getPatient($id);
    }
}