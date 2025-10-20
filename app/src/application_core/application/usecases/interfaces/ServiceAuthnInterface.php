<?php
namespace toubilib\core\application\usecases\interfaces;

use toubilib\api\dtos\InputAuthnDTO;

interface ServiceAuthnInterface {

    /**
     * Orchestre la connexion.
     * @param InputAuthnDTO $user_dto Les identifiants (email/mdp)
     * @param string $host Le nom d'hôte (ex: "api.mondomaine.com")
     * @return string Le token JWT
     */
    public function login(InputAuthnDTO $user_dto, string $host) : string; // Modifié ici
}