<?php

namespace toubilib\api\dtos;


use Exception;

class PatientDTO {
    public function __construct(
        public readonly string $id,
        public readonly string $nom,
        public readonly string $prenom,
        public readonly string $date_naissance,
        public readonly string $adresse,
        public readonly string $code_postal,
        public readonly string $ville,
        public readonly string $email,
        public readonly string $telephone
    ) {}
}