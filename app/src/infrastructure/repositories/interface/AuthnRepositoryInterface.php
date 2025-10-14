<?php

namespace toubilib\infra\repositories\interface;

use toubilib\core\domain\entities\user\User;

interface AuthnRepositoryInterface {
    public function getUser(string $email) : User;
}