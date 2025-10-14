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
    // exemple /praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/rdvs?duree=30&date_heure_debut=2025-10-07 15:00:00&date_heure_fin=2025-10-07 15:30:00&id_pat=d975aca7-50c5-3d16-b211-cf7d302cba50

//    DELETE
    $app->delete("/praticiens/{id_prat}/rdvs/{id_rdv}", AnnulerRdvAction::class);

    return $app;
};