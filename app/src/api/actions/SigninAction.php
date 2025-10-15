<?php

namespace toubilib\api\actions;
use _PHPStan_2d0955352\Nette\Neon\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\usecases\interfaces\ServiceAuthnInterface;

class SigninAction {
    private ServiceAuthnInterface $serviceAuthn;

    public function __construct(ServiceAuthnInterface $serviceAuthn) {
        $this->serviceAuthn = $serviceAuthn;
    }

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {

        $user_dto = $request->getAttribute('auth_dto') ?? null;

        if(empty($user_dto)) {
            throw new \Exception("Erreur récupération DTO de signin.");
        }

        try {
            $response->getBody()->write(json_encode($this->serviceAuthn->signin($user_dto)));
            return $response->withHeader("Content-Type", "application/json");
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}