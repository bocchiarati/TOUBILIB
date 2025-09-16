<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use toubilib\api\actions\HomeAction;
use toubilib\api\actions\PraticienAction;


return function( App $app): App {
    $app->get('/', HomeAction::class);
    $app->get('/praticiens/{id}', PraticienAction::class);

    return $app;
};