<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;

class AnnulerRdvAction {
    private ServiceRendezVousInterface $serviceRdv;

    public function __construct(ServiceRendezVousInterface $serviceRdv) {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id_rdv = RouteContext::fromRequest($request)
            ->getRoute()
            ->getArguments()['id_rdv'];
        $id_prat = RouteContext::fromRequest($request)
            ->getRoute()
            ->getArguments()['id_prat'];
        $response->getBody()->write(json_encode($this->serviceRdv->annulerRendezVous($id_prat, $id_rdv)));
        return $response->withHeader("Content-Type", "application/json");
    }
}