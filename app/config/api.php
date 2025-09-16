<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\HomeAction;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;

return [
    // application
    HomeAction::class=> function (ContainerInterface $c) {
        return new HomeAction($c->get(ServicePraticienInterface::class));
    },
];

