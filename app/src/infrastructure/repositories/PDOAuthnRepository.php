<?php

namespace toubilib\infra\repositories;

use DI\NotFoundException;
use Exception;
use PDO;
use Slim\Exception\HttpInternalServerErrorException;
use toubilib\core\domain\entities\user\User;
use toubilib\infra\repositories\interface\AuthnRepositoryInterface;

class PDOAuthnRepository implements AuthnRepositoryInterface {


    private PDO $authn_pdo;

    public function __construct(PDO $authn_pdo) {
        $this->authn_pdo = $authn_pdo;
    }

    public function getUser(string $email): User
    {
        try {
            $query = $this->authn_pdo->query("SELECT id, email, password, role FROM users WHERE email = '$email'");
            $res = $query->fetch(PDO::FETCH_ASSOC);
        } catch (HttpInternalServerErrorException) {
            //500
            throw new HttpInternalServerErrorException("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable) {
            throw new Exception("Erreur lors de la reception de l'utilisateur.");
        }
        if (!$res) {
            //404
            throw new NotFoundException("L'utilisateur ayant pour email ".$email." n'existe pas.");
        } else {
            return new User(
                id: $res['id'],
                email: $res['email'],
                password: $res['password'],
                role: $res['role']
            );
        }
    }
}