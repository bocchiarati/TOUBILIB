<?php

namespace toubilib\core\application\usecases;

use DateTime;
use toubilib\api\dtos\RendezVousDTO;
use toubilib\core\application\usecases\interfaces\ServicePatientInterface;
use toubilib\core\application\usecases\interfaces\ServicePraticienInterface;
use toubilib\core\application\usecases\interfaces\ServiceRendezVousInterface;
use toubilib\api\dtos\InputRendezVousDTO;
use toubilib\core\domain\entities\rdv\RendezVous;
use toubilib\infra\repositories\interface\RendezVousRepositoryInterface;
use function PHPUnit\Framework\containsEqual;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    private RendezVousRepositoryInterface $rendezVousRepository;
    private ServicePraticienInterface $servicePraticien;
    private ServicePatientInterface $servicePatient;

    public function __construct(RendezVousRepositoryInterface $rendezVousRepository, ServicePraticienInterface $servicePraticien, ServicePatientInterface $servicePatient)
    {
        $this->rendezVousRepository = $rendezVousRepository;
        $this->servicePraticien = $servicePraticien;
        $this->servicePatient = $servicePatient;
    }

    public function listerRDV(string $praticien_id, ?string $debut = null, ?string $fin = null): array {
        if(is_null($debut)) {
            $debut = (new \DateTime())->setTime(8, 0)->format('Y-m-d H:i:s');
        }
        if(is_null($fin)) {
            $fin = (new \DateTime())->setTime(19,0)->format('Y-m-d H:i:s');
        }

        try {
            return $this->rendezVousRepository->getCreneauxOccupees($debut, $fin, $praticien_id);
        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de l'obtention de la liste des RDV (Service)\n" . $th->getMessage());
        }
    }

    public function getRDV($id_rdv): RendezVousDTO {
        try {
            $rdv = $this->rendezVousRepository->getRDV($id_rdv);
            return new RendezVousDTO(
                id: $rdv->id,
                praticien_id: $rdv->praticien_id,
                patient_id: $rdv->patient_id,
                date_heure_debut: $rdv->date_heure_debut,
                status: $rdv->status,
                duree: $rdv->duree,
                date_heure_fin: $rdv->date_heure_fin,
                date_creation: $rdv->date_creation,
                motif_visite: $rdv->motif_visite
            );
        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de l'obtention du RDV (Service)\n" . $th->getMessage());
        }
    }

    public function creerRendezVous(InputRendezVousDTO $dto): array {
        try {
            //vérification si le praticien existe
            $prat = $this->servicePraticien->getPraticien($dto->praticien_id);
            //vérification si le patient existe
            $this->servicePatient->getPatient($dto->patient_id);
            //vérification si le motif de visite existe
            if(!(in_array($dto->motif_visite,$prat[0]['motifs_visite']))) {
                return [
                    "success" => false,
                    "message" => "RDV n'a pu etre cree.\nLe motif de visite n'existe pas pour ce praticien."
                ];
            }

            //vérification si le créneau est disponible
            $date_heure_debut = DateTime::createFromFormat('Y-m-d H:i:s', $dto->date_heure_debut);
            $date_heure_fin = DateTime::createFromFormat('Y-m-d H:i:s', $dto->date_heure_fin);
            $heureDebut = (int)$date_heure_debut->format('H');
            $minuteDebut = (int)$date_heure_debut->format('i');
            $heureFin = (int)$date_heure_fin->format('H');
            $minuteFin = (int)$date_heure_fin->format('i');
            //entre 8h et 19h
            if (!(($heureDebut >= 8) && ($heureFin < 19 || ($heureFin === 19 && $minuteFin === 0)))) {
                return [
                    'success' => false,
                    "message" => "RDV n'a pu etre cree.\nLes horaires doivent etre compris entre 8h et 19h."
                ];
            }

            //horaire debut < horaire fin
            if (($heureDebut < $heureFin) || (($heureDebut === $heureFin) && ($minuteFin <= $minuteDebut))) {
                return [
                    'success' => false,
                    "message" => "RDV n'a pu etre cree.\nLes horaires de fin du rdv ne peuvent etre avant les horaires de debut."
                ];
            }


            $nJourDebut = (int)$date_heure_debut->format('N');
            $nJourFin = (int)$date_heure_fin->format('N');
            //du lundi au venredi
            if (($nJourDebut > 5) || ($nJourFin > 5)) {
                return [
                    'success' => false,
                    "message" => "RDV n'a pu etre cree.\nLes horaires doivent etre compris entre lundi et vendredi."
                ];
            }

            //horaire debut = horaire fin
            if ($nJourFin !== $nJourDebut) {
                return [
                    'success' => false,
                    "message" => "RDV n'a pu etre cree.\nLe jour de debut et le jour de fin doivent etre les même."
                ];
            }

            //vérification praticien disponible
            $rdvs = $this->listerRDV($dto->praticien_id,$dto->date_heure_debut,$dto->date_heure_fin);
            if ($rdvs != []) {
                return [
                    'success' => false,
                    "message" => "RDV n'a pu etre cree.\nLe creneau est deja occupe."
                ];
            }

            $this->rendezVousRepository->createRdv($dto);
            return [
                'success' => true,
                "message" => "RDV cree."
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => "RDV n'a pu etre cree.\n" . $th->getMessage()
            ];
        }
    }

    public function annulerRendezVous($id_prat, $id_rdv): array {
        try {
            $rdv = $this->rendezVousRepository->getRDV($id_prat, $id_rdv);
            $rdv->annuler();
            return [
                "success" => true,
                "message" => "Le rendez-vous a bien ete annule."
            ];
        } catch (\Throwable $th) {
            return [
                "success" => false,
                "message" => "Erreur lors de l'annulation du rendez-vous.\n" . $th->getMessage()
            ];
        }
    }
}