<?php

use Psr\Container\ContainerInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\infra\repositories\PDOPraticienRepository;

return [
//    // service
//    UserStoryServiceInterface::class => function (ContainerInterface $c) {
//        return new UserStoryService($c->get(UserStoryRepository::class));
//    },


//    UserStoryRepository::class => fn(ContainerInterface $c) => new PgUserStoryRepository($c->get('jira.pdo')),
    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPraticienRepository($c->get("prat.pdo"));
    },
];

