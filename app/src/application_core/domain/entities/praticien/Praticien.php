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