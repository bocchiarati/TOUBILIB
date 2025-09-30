<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\ServicePraticien;

class PraticienAction {
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticienInterface $servicePraticien) {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id_prat = $args['id_prat'] ?? null;
        if(empty($id_prat)) {
            throw new \Exception("Saisissez un id de praticien");
        }

        try {

            $response->getBody()->write(json_encode($this->servicePraticien->getPraticien($id_prat)));
            return $response->withHeader("Content-Type", "application/json");
        } catch (\Exception) {
            throw new \Exception("Erreur lors de l'obtention des détail sur le praticien.");
        }
    }
}