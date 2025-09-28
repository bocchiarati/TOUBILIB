<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;

class RdvDetailsAction {
    private ServiceRendezVousInterface $serviceRdv;

    public function __construct(ServiceRendezVousInterface $serviceRdv) {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $rdv_id = RouteContext::fromRequest($request)
            ->getRoute()
            ->getArguments()['rdv_id'];
        $response->getBody()->write(json_encode(($this->serviceRdv->getRDV($rdv_id))));
        return $response->withHeader("Content-Type", "application/json");
    }
}