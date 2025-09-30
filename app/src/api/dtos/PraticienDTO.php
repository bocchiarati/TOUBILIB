<?php

namespace toubilib\api\dtos;


use Exception;

class PraticienDTO {
    public function __construct(
        public readonly string $id,
        public readonly string $nom,
        public readonly string $prenom,
        public readonly string $ville,
        public readonly string $email,
        public readonly string $telephone,
        public readonly string $specialite
    ) {}
}