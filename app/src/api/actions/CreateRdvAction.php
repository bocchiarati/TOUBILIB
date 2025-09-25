<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use toubilib\api\dtos\InputRendezVousDTO;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;

class CreateRdvAction {
    private ServiceRendezVousInterface $serviceRdv;

    public function __construct(ServiceRendezVousInterface $serviceRdv) {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        try {
            $response->getBody()->write(json_encode($this->serviceRdv->creerRendezVous($request->getAttribute('rdv_dto'))));
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode([
                "success" => false,
                "message" => "Erreur lors de la création d'un rendez-vous" . $e->getMessage()
            ]));
        }
        return $response->withHeader("Content-Type", "application/json");
    }
}