<?php

namespace toubilib\api\dtos;

use Exception;

class UserDTO {
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $role,
    ) {}

    public function __get(string $property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new Exception("La propriété '$property' n'existe pas.");
    }
}