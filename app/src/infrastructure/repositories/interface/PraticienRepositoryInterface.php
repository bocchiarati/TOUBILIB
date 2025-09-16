<?php

namespace toubilib\infra\repositories\interface;

interface PraticienRepositoryInterface {
    public function getPraticiens() : array;
    public function getCreneauxOccupees() : array;
}