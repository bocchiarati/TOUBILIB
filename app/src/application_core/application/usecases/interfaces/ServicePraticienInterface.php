<?php

namespace toubilib\core\application\usecases\interfaces;

use toubilib\api\dtos\PraticienDTO;

interface ServicePraticienInterface
{
    public function listerPraticiens(): array;
    public function getPraticien(string $id): PraticienDTO;
}