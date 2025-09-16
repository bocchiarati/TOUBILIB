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

    // infra
     'prat.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('db.config'));
        $dsn = "{$config['prat.driver']}:host={$config['prat.host']};dbname={$config['prat.database']}";
        $user = $config['prat.username'];
        $password = $config['prat.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },

    'rdv.pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('db.config'));
        $dsn = "{$config['rdv.driver']}:host={$config['rdv.host']};dbname={$config['rdv.database']}";
        $user = $config['rdv.username'];
        $password = $config['rdv.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },
];

