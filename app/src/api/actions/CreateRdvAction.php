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
        try {
            $id_pat = $args['id_pat'] ?? null;
            $id_prat = $args['id_prat'] ?? null;
            $date_heure_debut = $args['date_heure_debut'] ?? null;
            $date_heure_fin = $args['date_heure_fin'] ?? null;
            $duree = $args['duree'] ?? null;
            $motif = $args['motif'] ?? null;

            if ($id_prat == null || $id_pat == null || $date_heure_debut == null || $date_heure_fin == null || $duree == null || $motif == null) {
                $response->getBody()->write(json_encode([
                    "success" => false,
                    "message" => "Erreur lors de la création d'un rendez-vous"
                ]));
            } else {
                $response->getBody()->write(json_encode($this->serviceRdv->creerRendezVous(new InputRendezVousDTO($id_pat, $id_prat, $date_heure_debut, $date_heure_fin, $duree, $motif))));
            }
        } catch (\Throwable) {
            $response->getBody()->write(json_encode([
                "success" => false,
                "message" => "Erreur lors de la création d'un rendez-vous"
            ]));
        }
        return $response->withHeader("Content-Type", "application/json");
    }
}