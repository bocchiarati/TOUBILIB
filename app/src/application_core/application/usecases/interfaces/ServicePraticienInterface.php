<?php

namespace toubilib\core\application\usecases\interfaces;

interface ServicePraticienInterface
{
    public function listerPraticiens(): array;
    public function listerRDV(string $debut, string $fin, string $praticien_id): array;
}