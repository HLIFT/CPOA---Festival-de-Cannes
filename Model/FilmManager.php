<?php

    class FilmManager
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

        public function getByID($id)
        {
            $id = (int) $id;

            $query = $this->_bdd->prepare("SELECT * FROM film WHERE idfilm = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Film($donnees);   
        }

        public function getFilmsWithVip(Vip $vip)
        {
            $films = [];

            $query = $this->_bdd->prepare("SELECT film.idfilm, idselection, titre, anneeprod, anneesortie, duree, synopsis FROM film LEFT OUTER JOIN casting ON film.idfilm = casting.idfilm WHERE idvip = ?");
            $query->execute(array($vip->getIdVip()));

            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $films[] = new Film($donnees);
            }

            return $films;
        }

        public function getFilms()
        {
            $query = $this->_bdd->prepare("SELECT * FROM film");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function getFilmsVip($id)
        {
            $query = $this->_bdd->prepare("SELECT film.idfilm, titre FROM film LEFT OUTER JOIN casting ON film.idfilm = casting.idfilm WHERE idvip = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

        public function getFilmsNoVip($id)
        {
            $query = $this->_bdd->prepare("SELECT film.idfilm, titre FROM film LEFT OUTER JOIN casting ON film.idfilm = casting.idfilm WHERE idvip != ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }


        public function getIdFilm(Film $film)
        {
            $query = $this->_bdd->prepare("SELECT * FROM film WHERE idselection = ?, titre = ?, anneeprod = ?");
            $query->execute(array($film->getIdSelection(), $film->getTitre(), $film->getAnneeProd()));
            $result = $query->fetchAll();
            return $result;
        }
    }      

?>