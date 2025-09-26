<?php

namespace toubilib\infra\repositories;

use Exception;
use PDO;
use toubilib\infra\repositories\interface\PatientRepositoryInterface;

class PDOPatientRepository implements PatientRepositoryInterface {


    private PDO $patient_pdo;

    public function __construct(PDO $patient_pdo) {
        $this->patient_pdo = $patient_pdo;
    }

    public function getPatient(string $id): array {
        try {
            $query = $this->patient_pdo->query("SELECT nom, prenom FROM patient WHERE id = '$id'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($res) > 1) {
                throw new Exception("Erreur : plusieurs patients ont ete trouves.");
            } else {
                if (sizeof($res) == 0) {
                    throw new Exception("Le patient n'existe pas.");
                } else {
                    return $res[0];
                }
            }
        } catch (\Throwable $e) {
            throw new Exception("Erreur lors de la reception du patient.");
        }
    }
}