<?php

namespace toubilib\core\application\usecases;
use toubilib\api\dtos\AuthnDTO;
use toubilib\api\dtos\InputAuthnDTO;
use toubilib\core\application\usecases\interfaces\ServiceAuthnInterface;
use toubilib\core\exceptions\ConnexionException;
use toubilib\infra\repositories\interface\AuthnRepositoryInterface;

class ServiceAuthn implements ServiceAuthnInterface {
    private AuthnRepositoryInterface $serviceRepositoryInterface;

    public function __construct(AuthnRepositoryInterface $serviceRepositoryInterface) {
        $this->serviceRepositoryInterface = $serviceRepositoryInterface;
    }

    public function signin(InputAuthnDTO $user_dto): AuthnDTO {
        try {
            $user = $this->serviceRepositoryInterface->getUser($user_dto->email);
            if(password_verify($user_dto->password, $user->password)) {
                return new AuthnDTO(
                    id: $user->id,
                    email: $user->email,
                    password: $user->password,
                    role: $user->role
                );
            } else {
                //401 unauthorized
                throw new ConnexionException("Erreur lors de la connexion.");
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}