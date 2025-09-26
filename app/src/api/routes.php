<?php
declare(strict_types=1);

use Slim\App;
use toubilib\api\actions\CreateRdvAction;
use toubilib\api\actions\PraticiensRdvAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;
use toubilib\api\actions\PraticiensRdvDetailsAction;


return function( App $app): App {
    $app->get('/praticiens', PraticiensAction::class);
    $app->get('/praticiens/{id}', PraticienAction::class);
    $app->get("/praticiens/{id}/rdv", PraticiensRdvAction::class);
    $app->get("/praticiens/{id}/rdv/{date_debut}/{date_fin}", PraticiensRdvAction::class); // format date : 2000-01-01, 2025-12-02
    $app->get("/praticiens/{id}/rdv/{rdv_id}", PraticiensRdvDetailsAction::class);
    $app->get("/praticiens/{id_prat}/rdv/create/{id_pat}/{date_heure_debut}/{date_heure_fin}/{duree}/{motif}", CreateRdvAction::class)
        ->add(new \toubilib\api\middlewares\CreerRendezVousValidationMiddleware());
    return $app;
};