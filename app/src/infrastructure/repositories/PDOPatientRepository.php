<?php

namespace toubilib\infra\repositories;

use DI\NotFoundException;
use Exception;
use PDO;
use Slim\Exception\HttpInternalServerErrorException;
use toubilib\core\domain\entities\patient\Patient;
use toubilib\infra\repositories\interface\PatientRepositoryInterface;

class PDOPatientRepository implements PatientRepositoryInterface {


    private PDO $patient_pdo;

    public function __construct(PDO $patient_pdo) {
        $this->patient_pdo = $patient_pdo;
    }

    public function getPatient(string $id): Patient {
        try {
            $query = $this->patient_pdo->query("SELECT id, nom, prenom, date_naissance, adresse, code_postal, ville, email, telephone FROM patient WHERE id = '$id'");
            $res = $query->fetch(PDO::FETCH_ASSOC);
        } catch (HttpInternalServerErrorException) {
            //500
            throw new HttpInternalServerErrorException("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable) {
            throw new Exception("Erreur lors de la reception du patient.");
        }
        if (!$res) {
            //404
            throw new NotFoundException("Le patient ayant pour id ".$id." n'existe pas.");
        } else {
            return new Patient(
                id: $res['id'],
                nom: $res['nom'],
                prenom: $res['prenom'],
                date_naissance: $res['date_naissance'],
                adresse: $res['adresse'],
                code_postal: $res['code_postal'],
                ville: $res['ville'],
                email: $res['email'],
                telephone: $res['telephone']
            );
        }
    }
}