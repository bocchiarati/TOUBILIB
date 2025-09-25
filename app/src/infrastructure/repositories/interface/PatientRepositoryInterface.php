<?php

namespace toubilib\infra\repositories\interface;

interface PatientRepositoryInterface {
    public function getPatient(string $id) : array;
}