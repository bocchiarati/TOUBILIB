<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\ServicePraticien;

class PraticiensRdvDetailsAction {
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticien $servicePraticien) {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id = RouteContext::fromRequest($request)
            ->getRoute()
            ->getArguments()['id'];
        $rdv_id = RouteContext::fromRequest($request)
            ->getRoute()
            ->getArguments()['rdv_id'];
        $response->getBody()->write(json_encode($this->servicePraticien->getRDV($id, $rdv_id)));
        return $response->withHeader("Content-Type", "application/json");
    }
}