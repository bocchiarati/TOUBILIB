<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class PraticiensAction {
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticienInterface $servicePraticien) {
        $this->servicePraticien = $servicePraticien;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        try {
            $response->getBody()->write(json_encode($this->servicePraticien->listerPraticiens()));
            return $response->withHeader("Content-Type", "application/json");
        } catch (\Exception) {
            throw new \Exception("Erreur lors de la récupération de la liste des praticiens.");
        }
    }
}