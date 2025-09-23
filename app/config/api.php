<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\PraticiensRdvAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;
use toubilib\api\actions\PraticiensRdvDetailsAction;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;

return [
    // application
    PraticiensAction::class=> function (ContainerInterface $c) {
        return new PraticiensAction($c->get(ServicePraticienInterface::class));
    },
    PraticienAction::class=> function (ContainerInterface $c) {
        return new PraticienAction($c->get(ServicePraticienInterface::class));
    },
    PraticiensRdvAction::class=> function (ContainerInterface $c) {
        return new PraticiensRdvAction($c->get(ServicePraticienInterface::class));
    },
    PraticiensRdvDetailsAction::class=> function (ContainerInterface $c) {
        return new PraticiensRdvDetailsAction($c->get(ServicePraticienInterface::class));
    },
];

