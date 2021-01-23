<?php
    class Film
    {
        private $_idFilm;
        private $_idSelection;
        private $_titre;
        private $_anneeProd;
        private $_anneeSortie;
        private $_duree;
        private $_synopsis;
        private $_jacket;

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

        function getIdFilm()
        {
            return $this->_idFilm;
        }

        function getIdSelection()
        {
            return $this->_idSelection;
        }

        function getTitre()
        {
            return $this->_titre;
        }

        function getAnneeProd()
        {
            return $this->_anneeProd;
        }

        function getAnneeSortie()
        {
            return $this->_anneeSortie;
        }

        function getDuree()
        {
            return $this->_duree;
        }

        function getSynopsis()
        {
            return $this->_synopsis;
        }

        function getJacket()
        {
            return $this->_jacket;
        }

        // ----- Setters ----- //

        function setIdFilm($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idFilm = $id;
            }
        }

        function setIdSelection($id)
        {
            $id = (int) $id;

            if ($id > 0)
            {
                $this->_idSelection = $id;
            }
        }

        function setTitre($titre)
        {
            if (is_string($titre))
            {
                $this->_titre = $titre;
            }
        }

        function setAnneeProd($annee)
        {
            $annee = (int) $annee;
            if ($annee >= 0)
            {
                $this->_anneeProd = $annee;
            }
        }

        function setAnneeSortie($annee)
        {
            $annee = (int) $annee;
            if ($annee >= 0) 
            {
                $this->_anneeSortie = $annee;
            }
        }

        function setDuree($duree)
        {
            $duree = (int) $duree;
            if ($duree > 0)
            {
                $this->_duree = $duree;
            }
        }

        function setSynopsis($synopsis)
        {
            $synopsis = (float) $synopsis;
            if (($synopsis >= 0) && ($synopsis <= 10))
            {
                $this->_synopsis = $synopsis;
            }
        }

        function setJacket($jacket)
        {
            if(is_string($jacket))
            {
                $this->_jacket = $jacket;
            }
        }

    }
?>