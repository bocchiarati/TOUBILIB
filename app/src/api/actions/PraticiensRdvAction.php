<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Rules\Date;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\ServicePraticien;

class PraticiensRdvAction {
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticien $servicePraticien) {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = $args['id'] ?? null;
        $date_debut = $args['date_debut'] ?? null;
        $date_fin = $args['date_fin'] ?? null;

        if(is_null($id)) {
            $response->getBody()->write(json_encode(["Praticien introuvable"]));
        }
        $response->getBody()->write(json_encode($this->servicePraticien->listerRDV($date_debut, $date_fin, $id)));
        return $response->withHeader("Content-Type", "application/json");
    }
}