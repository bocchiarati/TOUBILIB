<?php
namespace toubilib\core\application\usecases;

use toubilib\core\application\usecases\interfaces\AuthnProviderInterface;
use toubilib\core\application\usecases\interfaces\ServiceAuthnInterface;
use toubilib\api\dtos\InputAuthnDTO;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ServiceAuthn implements ServiceAuthnInterface {

    private AuthnProviderInterface $userProvider;
    private string $secretKey;

    public function __construct(AuthnProviderInterface $provider, string $jwtSecret) {
        $this->userProvider = $provider;
        $this->secretKey = $jwtSecret;
    }

    public function login(InputAuthnDTO $user_dto, string $host) : string {

        // 1. On valide l'utilisateur
        $user = $this->userProvider->signin($user_dto);

        // 2. On construit le payload
        $payload = [
            "iss" => $host,
            "aud" => $host,
            "iat" => time(),
            "exp" => time() + 3600,
            "sub" => $user->id,
            "data" => [
                "email" => $user->email,
                "role" => $user->role,
            ]
        ];

        // 3. On encode et on return
        return JWT::encode($payload, $this->secretKey, 'HS512');
    }

}