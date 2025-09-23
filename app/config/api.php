<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\PraticiensRdvAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;
use toubilib\api\actions\PraticiensRdvDetailsAction;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;

return [
    // application
    PraticiensAction::class=> function (ContainerInterface $c) {
        return new PraticiensAction($c->get(ServicePraticienInterface::class));
    },
    PraticienAction::class=> function (ContainerInterface $c) {
        return new PraticienAction($c->get(ServicePraticienInterface::class));
    },
    PraticiensRdvAction::class=> function (ContainerInterface $c) {
        return new PraticiensRdvAction($c->get(ServiceRendezVousInterface::class));
    },
    PraticiensRdvDetailsAction::class=> function (ContainerInterface $c) {
        return new PraticiensRdvDetailsAction($c->get(ServiceRendezVousInterface::class));
    },
];

