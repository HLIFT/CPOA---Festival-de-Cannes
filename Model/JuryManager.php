<?php

    class JuryManager
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

            $query = $this->_bdd->prepare("SELECT * FROM jury WHERE idjury = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Jury($donnees);
        }
    }