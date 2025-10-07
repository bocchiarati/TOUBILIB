<?php

namespace toubilib\core\domain\entities\patient;

use Exception;

class Patient {
    private string $id;
    private string $nom;
    private string $prenom;
    private string $date_naissance;
    private string $adresse;
    private string $code_postal;
    private string $ville;
    private string $email;
    private string $telephone;

    public function __construct(
        string $id,
        string $nom,
        string $prenom,
        string $date_naissance,
        string $adresse,
        string $code_postal,
        string $ville,
        string $email,
        string $telephone
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->ville = $ville;
        $this->email = $email;
        $this->telephone = $telephone;
    }

    /**
     * @throws Exception
     */
    public function __get(string $property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new Exception("La propriété '$property' n'existe pas.");
    }
}
