<?php

namespace toubilib\core\application\usecases;
use toubilib\api\dtos\PatientDTO;
use toubilib\core\application\usecases\interfaces\ServicePatientInterface;
use toubilib\infra\repositories\interface\PatientRepositoryInterface;

class ServicePatient implements ServicePatientInterface {
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * @throws \Exception
     */
    public function getPatient(string $id): PatientDTO {
        try {
            $pat = $this->patientRepository->getPatient($id);
        } catch (\Throwable $th) {
            throw new \Exception("Erreur ".$th->getCode().": probleme lors de la reception du patient.");
        }
        return new PatientDTO(
            id: $pat->id,
            nom: $pat->nom,
            prenom: $pat->prenom,
            date_naissance: $pat->date_naissance,
            adresse: $pat->adresse,
            code_postal: $pat->code_postal,
            ville: $pat->ville,
            email: $pat->email,
            telephone: $pat->telephone
        );
    }
}