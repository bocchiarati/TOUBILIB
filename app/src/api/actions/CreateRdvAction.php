<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\api\dtos\InputRendezVousDTO;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;

class CreateRdvAction {
    private ServiceRendezVousInterface $serviceRdv;

    public function __construct(ServiceRendezVousInterface $serviceRdv) {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $response->getBody()->write(json_encode($this->serviceRdv->creerRendezVous(new InputRendezVousDTO("0768e78b-12c8-3694-b89b-d0a7451a8fb1", "e9613aa0-3cdd-38ac-8e1e-2588bc1ce1ca", '2025-12-04 18:30:00', '2025-12-04 18:15:00', 15, "test"))));
        return $response->withHeader("Content-Type", "application/json");
    }
}