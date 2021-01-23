<?php
    class Casting
    {
        private $_idCasting;
        private $_idFilm;
        private $_idVip;

        // ----- Constructeur ----- //

        function __construct($donnees)
        {
            $this->hydrate($donnees);
        }

        // ----- Hydrate ----- //

        public function hydrate(array $donnees)
        {

            foreach ($donnees as $key => $value) // Chaque champ est lu
            {
                // On récupère le nom du setter correspondant à l'attribut de la classe.
                $method = 'set'.ucfirst($key);
                // Si le setter correspondant existe.
                if (method_exists($this, $method))
                {
                    // On appelle le setter.
                    $this->$method($value);
                }
            }
        }

        // ----- Getters ----- //

        function getIdCasting()
        {
            return $this->_idCasting;
        }

        function getIdFilm()
        {
            return $this->_idFilm;
        }

        function getIdVip()
        {
            return $this->_idVip;
        }

        // ----- Setters ----- //

        function setIdCasting($idCasting)
        {
            $idCasting = (int) $idCasting;
            $this->_idCasting = $idCasting;
        }

        function setIdFilm($idFilm)
        {
            $idFilm = (int) $idFilm;
            $this->_idFilm = $idFilm;
        }

        function setIdVip($idVip)
        {
            $idVip = (int) $idVip;
            $this->_idVip = $idVip;
        }

    }
?>