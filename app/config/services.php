<?php

use Psr\Container\ContainerInterface;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\core\application\usecases\ServiceRendezVous;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\infra\repositories\interface\RendezVousRepositoryInterface;
use toubilib\infra\repositories\PDOPraticienRepository;
use toubilib\infra\repositories\PDORendezVousRepository;

return [
    // SERVICES
    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPraticienRepository($c->get("prat.pdo"));
    },

    RendezVousRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDORendezVousRepository($c->get("rdv.pdo"));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    ServiceRendezVousInterface::class => function (ContainerInterface $c) {
        return new ServiceRendezVous($c->get(RendezVousRepositoryInterface::class));
    },
];

