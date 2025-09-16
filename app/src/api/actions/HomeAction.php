<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class HomeAction {
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticien $servicePraticien) {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {

        $response->getBody()->write(json_encode($this->servicePraticien->listerPraticiens()));
        return $response->withHeader("Content-Type", "application/json");
    }
}