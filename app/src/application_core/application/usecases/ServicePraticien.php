<?php

namespace toubilib\core\application\usecases;
use Exception;
use toubilib\api\dtos\PraticienDTO;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\exceptions\EntityNotFoundException;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class ServicePraticien implements ServicePraticienInterface {
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    /**
     * @throws Exception
     */
    public function listerPraticiens(): array {
        try {
            $praticiens = $this->praticienRepository->getPraticiens();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'obtention des praticiens\n Message erreur PDO : " . $e->getMessage());
        }

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
    }

    /**
     * @throws \Exception
     */
    public function getPraticien(string $id): PraticienDTO {
        try {
            $praticien = $this->praticienRepository->getPraticien($id);
        } catch (EntityNotFoundException $e) {
            throw new EntityNotFoundException($e->getMessage(), $e->getEntity());
        } catch (\Exception $e) {
            throw new \Exception("probleme lors de la reception du praticien.", $e->getCode());
        }
        return new PraticienDTO(
            id: $praticien->id,
            nom: $praticien->nom,
            prenom: $praticien->prenom,
            ville: $praticien->ville,
            email: $praticien->email,
            telephone: $praticien->telephone,
            specialite: $praticien->specialite,
            moyens_paiement: $praticien->moyens_paiement,
            motifs_visite: $praticien->motifs_visite,
        );
    }
}