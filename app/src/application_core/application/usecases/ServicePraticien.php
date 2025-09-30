<?php

namespace toubilib\core\application\usecases;
use Respect\Validation\Rules\Date;
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
            return $this->praticienRepository->getPraticiens();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'obtention de la liste des praticiens (Service). \n Message erreur PDO : " . $e->getMessage());
        }
    }

    public function getPraticien(string $id): array {
        try {
            return $this->praticienRepository->getPraticien($id);
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'obtention du praticien " . $id . ". \n Message erreur PDO : " . $e->getMessage());
        }
    }
}