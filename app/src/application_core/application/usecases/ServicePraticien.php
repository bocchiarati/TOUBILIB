<?php

namespace toubilib\core\application\usecases;
use toubilib\api\dtos\PraticienDTO;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class ServicePraticien implements ServicePraticienInterface {
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    /**
     * @throws \Exception
     */
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
        } catch (\Throwable $th) {
            throw new \Exception("Erreur ".$th->getCode().": probleme lors de la reception des praticiens.");
        }
    }

    /**
     * @throws \Exception
     */
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
        } catch (\Throwable $th) {
            throw new \Exception("Erreur ".$th->getCode().": probleme lors de la reception du praticien.");
        }
    }
}