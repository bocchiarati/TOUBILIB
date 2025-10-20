<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\AnnulerRdvAction;
use toubilib\api\actions\CreateRdvAction;
use toubilib\api\actions\PraticienRdvAction;
use toubilib\api\actions\PraticiensAction;
use toubilib\api\actions\PraticienAction;
use toubilib\api\actions\RdvDetailsAction;
use toubilib\api\actions\SigninAction;
use toubilib\api\middlewares\AuthnSigninValidationMiddleware;
use toubilib\api\middlewares\AuthzAccessRdvDetailMiddleware;
use toubilib\api\middlewares\AuthzAccessRdvsMiddleware;
use toubilib\api\middlewares\AuthzCreationMiddleware;
use toubilib\api\middlewares\AuthzSuppressionMiddleware;
use toubilib\api\middlewares\JwtAuthMiddleware;
use toubilib\core\application\usecases\interfaces\ServiceAuthnInterface;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;

return [
    // application
    PraticiensAction::class=> function (ContainerInterface $c) {
        return new PraticiensAction($c->get(ServicePraticienInterface::class));
    },
    PraticienAction::class=> function (ContainerInterface $c) {
        return new PraticienAction($c->get(ServicePraticienInterface::class));
    },
    PraticienRdvAction::class=> function (ContainerInterface $c) {
        return new PraticienRdvAction($c->get(ServiceRendezVousInterface::class));
    },
    RdvDetailsAction::class=> function (ContainerInterface $c) {
        return new RdvDetailsAction($c->get(ServiceRendezVousInterface::class));
    },
    CreateRdvAction::class=> function (ContainerInterface $c) {
        return new CreateRdvAction($c->get(ServiceRendezVousInterface::class));
    },
    AnnulerRdvAction::class=> function (ContainerInterface $c) {
        return new AnnulerRdvAction($c->get(ServiceRendezVousInterface::class));
    },
    SigninAction::class=> function (ContainerInterface $c) {
        return new SigninAction($c->get(ServiceAuthnInterface::class));
    },

    AuthzSuppressionMiddleware::class => function (ContainerInterface $c) {
        return new AuthzSuppressionMiddleware($c->get(ServiceAuthzPatientInterface::class), $c->get(ServiceAuthzPraticienInterface::class), $c->get(ServiceRendezVousInterface::class));
    },

    AuthnSigninValidationMiddleware::class => function (ContainerInterface $c) {
        return new AuthnSigninValidationMiddleware();
    },

    JwtAuthMiddleware::class => function (ContainerInterface $c) {
        return new JwtAuthMiddleware(parse_ini_file($c->get('db.config'))["JWT_SECRET"]);
    }
];

