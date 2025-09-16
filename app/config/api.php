<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\HomeAction;
use toubilib\api\actions\PraticienAction;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;

return [
    // application
    HomeAction::class=> function (ContainerInterface $c) {
        return new HomeAction($c->get(ServicePraticienInterface::class));
    },
    PraticienAction::class=> function (ContainerInterface $c) {
        return new PraticienAction($c->get(ServicePraticienInterface::class));
    },
];

