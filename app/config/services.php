<?php

use Psr\Container\ContainerInterface;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\interfaces\ServiceRdvInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\core\application\usecases\ServiceRdv;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\infra\repositories\PDOPraticienRepository;

return [
    // SERVICES
    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPraticienRepository($c->get("prat.pdo"), $c->get("rdv.pdo"));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    ServiceRdvInterface::class => function (ContainerInterface $c) {
        return new ServiceRdv($c->get(PraticienRepositoryInterface::class));
    },
];

