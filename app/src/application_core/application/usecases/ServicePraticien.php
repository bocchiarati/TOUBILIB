<?php

namespace toubilib\core\application\usecases;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;


class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function listerPraticiens(): array {
    	
    }
}