<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\HomeAction;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;
use toubilib\infra\repositories\PDOPraticienRepository;

return [
    // settings
    'displayErrorDetails' => true,
    'logs.dir' => __DIR__ . '/../var/logs',
    'db.config' => __DIR__ . '/.env',
    
    // application
    HomeAction::class=> function (ContainerInterface $c) {
        return new HomeAction($c->get(PraticienRepositoryInterface::class));
    },

//    // service
//    UserStoryServiceInterface::class => function (ContainerInterface $c) {
//        return new UserStoryService($c->get(UserStoryRepository::class));
//    },

    // infra
     'prat.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('db.config'));
        $dsn = "{$config['prat.driver']}:host={$config['prat.host']};dbname={$config['prat.database']}";
        $user = $config['prat.username'];
        $password = $config['prat.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },

//    UserStoryRepository::class => fn(ContainerInterface $c) => new PgUserStoryRepository($c->get('jira.pdo')),
    PraticienRepositoryInterface::class => function (ContainerInterface $c) {
        return new PDOPraticienRepository($c->get("prat.pdo"));
    },
];

