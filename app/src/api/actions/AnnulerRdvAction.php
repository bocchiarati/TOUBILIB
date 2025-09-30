<?php

namespace toubilib\api\actions;
use _PHPStan_2d0955352\Nette\Neon\Exception;
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
        $id_prat = $args['id_prat'] ?? null;
        $id_rdv = $args['id_rdv'] ?? null;

        if(empty($id_prat)) {
            throw new \Exception("Saisissez un id de Praticien");
        }

        if(empty($id_rdv)) {
            throw new \Exception("Saisissez un id de Rendez vous");
        }

        try {
            $response->getBody()->write(json_encode($this->serviceRdv->annulerRendezVous($id_prat, $id_rdv)));
            return $response->withHeader("Content-Type", "application/json");
        } catch (\Exception ) {
            $message_complementaire = "";
            if(empty($args['id_rdv'])) {
                $message_complementaire = "l'id du rendez vous est vide";
            }
            throw new Exception("Erreur lors de l'annulation du RDV. " . $message_complementaire);
        }
    }
}