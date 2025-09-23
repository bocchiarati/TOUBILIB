<?php
declare(strict_types=1);

use Slim\App;
use toubilib\api\actions\PraticiensRdvAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;


return function( App $app): App {
    $app->get('/praticiens', PraticiensAction::class);
    $app->get('/praticiens/{id}', PraticienAction::class);
    $app->get("/praticiens/{id}/rdv", PraticiensRdvAction::class);
    $app->get("/praticiens/{id}/rdv/{rdv_id}", PraticiensRdvDetailsAction::class);
    return $app;
};