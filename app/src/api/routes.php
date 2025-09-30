<?php
declare(strict_types=1);

use Slim\App;
use toubilib\api\actions\AnnulerRdvAction;
use toubilib\api\actions\CreateRdvAction;
use toubilib\api\actions\PraticiensRdvAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;
use toubilib\api\actions\RdvDetailsAction;


return function( App $app): App {
//    GET
    $app->get('/praticiens', PraticiensAction::class);
    $app->get('/praticiens/{id_prat}', PraticienAction::class);
    $app->get("/praticiens/{id_prat}/rdvs", PraticiensRdvAction::class);
    $app->get("/praticiens/{id_prat}/rdvs/{rdv_id}", RdvDetailsAction::class);

//    POST
    $app->post("/praticiens/{id_prat}/rdvs", CreateRdvAction::class)
        ->add(new \toubilib\api\middlewares\CreerRendezVousValidationMiddleware());

//    DELETE
    $app->delete("/praticiens/{id_prat}/rdvs/{id_rdv}", AnnulerRdvAction::class);

    return $app;
};