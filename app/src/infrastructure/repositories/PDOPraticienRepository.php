<?php

namespace toubilib\infra\repositories;

use Exception;
use PDO;
use Slim\Exception\HttpInternalServerErrorException;
use toubilib\core\domain\entities\praticien\Praticien;
use toubilib\core\exceptions\EntityNotFoundException;
use toubilib\infra\repositories\interface\PraticienRepositoryInterface;

class PDOPraticienRepository implements PraticienRepositoryInterface {


    private PDO $prati_pdo;

    public function __construct(PDO $prati_pdo) {
        $this->prati_pdo = $prati_pdo;
    }

    public function getPraticiens() : array {
        try {
            $query = $this->prati_pdo->query("SELECT praticien.id, nom, prenom, ville, email, specialite.libelle, telephone, email as specialite FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id");
            $array = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (HttpInternalServerErrorException $e) {
            //500
            throw new Exception("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable $e) {
            throw new Exception("Erreur lors de la reception des praticiens.");
        }
        $res = [];
        foreach ($array as $praticien) {
            $res[] = new Praticien(
                id: $praticien['id'],
                nom: $praticien['nom'],
                prenom: $praticien['prenom'],
                ville: $praticien['ville'],
                email: $praticien['email'],
                telephone: $praticien['telephone'],
                specialite: $praticien['specialite']
            );
        }
        return $res;
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function getPraticien($id): Praticien {
        try {
            $query = $this->prati_pdo->query("SELECT praticien.id, praticien.nom, praticien.ville, praticien.email, praticien.prenom, specialite.libelle as specialite, praticien.email, praticien.telephone FROM praticien
                                          INNER JOIN specialite ON praticien.specialite_id = specialite.id
                                          WHERE praticien.id = '$id'");
        } catch (HttpInternalServerErrorException $e) {
            //500
            throw new Exception("Erreur lors de l'execution de la requete SQL.");
        } catch(\Throwable $e) {
            throw new Exception("Erreur lors de la reception du praticien.");
        }

        $array = $query->fetch(PDO::FETCH_ASSOC);
        if(!$array) {
            throw new EntityNotFoundException("praticien introuvable.", "praticien");
        }

        try {
            $array['moyens_paiement'] = $this->getMoyenPaiement($id);
        } catch(\Exception $e) {
            throw new Exception("Erreur lors de la reception du moyen de paiement.", 500);
        }

        try {
            $array['motifs_visite'] = $this->getMotifsVisite($id);
        } catch(\Exception $e) {
            throw new Exception("Erreur lors de la reception des motifs de visite.", 500);
        }

        return new Praticien(
            id: $array['id'],
            nom: $array['nom'],
            prenom: $array['prenom'],
            ville: $array['ville'],
            email: $array['email'],
            telephone: $array['telephone'],
            specialite: $array['specialite'],
            moyens_paiement: $array['moyens_paiement'],
            motifs_visite: $array['motifs_visite']
        );
    }

    /**
     * @throws Exception
     */
    private function getMotifsVisite($id) : array {
        try {
            $motifs_visite = $this->prati_pdo->query("SELECT motif_visite.libelle as motif_visite FROM motif_visite
                                           INNER JOIN praticien2motif ON motif_visite.id = praticien2motif.motif_id
                                           WHERE praticien2motif.praticien_id = '$id'");
        } catch(\Throwable $e) {
            throw new Exception("Erreur lors de la reception des motifs de visite.");
        }

        $res = $motifs_visite->fetchAll(PDO::FETCH_ASSOC);
        return array_column($res, "motif_visite");
    }

    private function getMoyenPaiement($id) : array {
        try {
            $moyens_paiement = $this->prati_pdo->query("SELECT moyen_paiement.libelle as moyen_paiement FROM moyen_paiement
                                           INNER JOIN praticien2moyen ON moyen_paiement.id = praticien2moyen.moyen_id
                                           WHERE praticien2moyen.praticien_id = '$id'");
        } catch(\Throwable $e) {
            throw new Exception("Erreur lors de la reception du moyen de paiement.");
        }

        $res = $moyens_paiement->fetchAll(PDO::FETCH_ASSOC);
        return array_column($res, "moyen_paiement");
    }
}