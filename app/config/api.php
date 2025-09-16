<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\HomeAction;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

return [
    // application
    HomeAction::class=> function (ContainerInterface $c) {
        return new HomeAction($c->get(PraticienRepositoryInterface::class));
    },
];

