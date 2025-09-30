<?php

namespace toubilib\core\domain\entities\praticien;


use Exception;

class Praticien {
    private string $id;
    private string $nom;
    private string $prenom;
    private string $ville;
    private string $email;
    private string $telephone;
    private string $specialite;

    public function __construct(
        string $id,
        string $nom,
        string $prenom,
        string $ville,
        string $email,
        string $telephone,
        string $specialite
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->ville = $ville;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->specialite = $specialite;
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