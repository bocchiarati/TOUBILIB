<?php

namespace toubilib\core\application\usecases;
use Respect\Validation\Rules\Date;
use toubilib\api\dtos\PraticienDTO;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\infra\repositories\PDOPraticienRepository;

class ServicePraticien implements ServicePraticienInterface {
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function listerPraticiens(): array {
        try {
            $praticiens = $this->praticienRepository->getPraticiens();
            $res = [];
            foreach ($praticiens as $praticien) {
                $res[] = new PraticienDTO(
                    id: $praticien->id,
                    nom: $praticien->nom,
                    prenom: $praticien->prenom,
                    ville: $praticien->ville,
                    email: $praticien->email,
                    telephone: $praticien->telephone,
                    specialite: $praticien->specialite
                );
            }
            return $res;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'obtention du praticien " . $id . ". \n Message erreur PDO : " . $e->getMessage());
        }
    }

    public function getPraticien(string $id): PraticienDTO {
        try {
            $praticien = $this->praticienRepository->getPraticien($id);
            return new PraticienDTO(
                id: $praticien->id,
                nom: $praticien->nom,
                prenom: $praticien->prenom,
                ville: $praticien->ville,
                email: $praticien->email,
                telephone: $praticien->telephone,
                specialite: $praticien->specialite
            );
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'obtention du praticien " . $id . ". \n Message erreur PDO : " . $e->getMessage());
        }
    }
}