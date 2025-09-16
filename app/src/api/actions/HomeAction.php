<?php

namespace toubilib\api\actions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class HomeAction {
    private PraticienRepositoryInterface $praticienRepositoryInterface;

    public function __construct(PraticienRepositoryInterface $praticienRepositoryInterface) {
        $this->praticienRepositoryInterface = $praticienRepositoryInterface;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {

        $response->getBody()->write(json_encode($this->praticienRepositoryInterface->getPraticiens()));
        return $response->withHeader("Content-Type", "application/json");
    }
}