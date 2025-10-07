<?php
declare(strict_types=1);

use Slim\App;
use toubilib\api\actions\AnnulerRdvAction;
use toubilib\api\actions\CreateRdvAction;
use toubilib\api\actions\PraticienRdvAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;
use toubilib\api\actions\RdvDetailsAction;
use toubilib\api\middlewares\CreerRendezVousValidationMiddleware;


return function( App $app): App {
//    GET
    $app->get('/praticiens', PraticiensAction::class);
    $app->get('/praticiens/{id_prat}', PraticienAction::class);
    $app->get("/praticiens/{id_prat}/rdvs", PraticienRdvAction::class);
    $app->get("/praticiens/{id_prat}/rdvs/{rdv_id}", RdvDetailsAction::class);

//    POST
    $app->post("/praticiens/{id_prat}/rdvs", CreateRdvAction::class)
        ->add(new CreerRendezVousValidationMiddleware());

//    DELETE
    $app->delete("/praticiens/{id_prat}/rdvs/{id_rdv}", AnnulerRdvAction::class);

    return $app;
};