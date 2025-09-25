<?php

namespace toubilib\core\application\usecases\interfaces;

interface ServicePatientInterface {
    public function getPatient(string $id): array;
}