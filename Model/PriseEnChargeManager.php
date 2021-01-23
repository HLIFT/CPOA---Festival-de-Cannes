<?php

    class PriseEnChargeManager
    {
        private $_bdd;

        // ----- Constructeur ----- //

        function __construct($bdd) 
        {
            $this->setBdd($bdd); 
        }

        // ----- Setters ----- //

        public function setBdd(PDO $bdd)
        {
            $this->_bdd = $bdd;
        }

        // ----- Méthodes ----- //

        public function getById($id)
        {
            $id = (int) $id;

            $query = $this->_bdd->prepare("SELECT * FROM niveaupriseencharge WHERE idnpec = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new PriseEnCharge($donnees);
        }


        function getNpecs()
        {
            $query = $this->_bdd->prepare("SELECT * FROM niveaupriseencharge");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

    }      

?>