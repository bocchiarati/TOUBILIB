<?php

namespace toubilib\infra\repositories\interface;

use toubilib\core\domain\entities\praticien\Praticien;

interface PraticienRepositoryInterface {
    public function getPraticiens() : array;
    public function getPraticien($id): Praticien;
}