<?php

namespace toubilib\infra\repositories\interface;

use Respect\Validation\Rules\Date;

interface PraticienRepositoryInterface {
    public function getPraticiens() : array;
    public function getCreneauxOccupees(string $debut, string $fin, string $praticien_id) : array;
}