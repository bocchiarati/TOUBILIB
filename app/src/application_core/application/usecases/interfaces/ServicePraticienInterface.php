<?php

namespace toubilib\core\application\usecases\interfaces;

interface ServicePraticienInterface
{
    public function listerPraticiens(): array;
    public function getPraticien($id): array;
}