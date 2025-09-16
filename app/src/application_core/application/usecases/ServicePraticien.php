<?php

namespace toubilib\core\application\usecases;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function listerPraticiens(): array {
    	return $this->praticienRepository->getPraticiens();
    }

    public function getPraticien($id): array {
        return $this->praticienRepository->getPraticien($id);
    }
}