<?php
declare(strict_types=1);

use Slim\App;
use toubilib\api\actions\HomeAction;
use toubilib\api\actions\RDVAction;


return function( App $app): App {
    $app->get("/rdv", RDVAction::class);
    $app->get('/', HomeAction::class);

    return $app;
};