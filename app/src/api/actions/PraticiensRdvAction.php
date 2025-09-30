<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;

class PraticiensRdvAction {
    private ServiceRendezVousInterface $serviceRdv;

    public function __construct(ServiceRendezVousInterface $serviceRdv) {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $id_prat = $args['id_prat'] ?? null;
        if(empty($id_prat)) {
            throw new \Exception("Saisissez un id de praticien");
        }

        $queryParams = $request->getQueryParams();
        $date_debut = $queryParams['date_debut'] ?? null;
        $date_fin = $queryParams['date_fin'] ?? null;

        try {
            $response->getBody()->write(json_encode($this->serviceRdv->listerRDV($id_prat, $date_debut, $date_fin)));
            return $response->withHeader("Content-Type", "application/json");
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la récupération des Rendez Vous du praticiens");
        }
    }
}