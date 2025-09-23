<?php
declare(strict_types=1);

use Slim\App;
use toubilib\api\actions\RDVAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;


return function( App $app): App {
    $app->get('/praticiens', PraticiensAction::class);
    $app->get('/praticiens/{id}', PraticienAction::class);
    $app->get("/rdv/{id}", RDVAction::class);
    return $app;
};