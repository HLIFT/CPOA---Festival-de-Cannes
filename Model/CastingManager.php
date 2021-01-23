<?php

    class CastingManager
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

        public function add(Casting $casting)
        {
            $query = $this->_bdd->prepare("INSERT INTO casting(idfilm, idvip) VALUES(?, ?)");
            $query->execute(array($casting->getIdFilm(), $casting->getIdVip()));

            $casting->hydrate([
                'idcasting' => $this->_bdd->lastInsertId(),
                'idfilm' => $casting->getIdFilm(),
                'idvip' => $casting->getIdVip()
            ]);
        }

        public function update(Casting $casting)
        {
            $query = $this->_bdd->prepare("UPDATE casting SET idfilm = ?, idvip = ? WHERE idcasting = ?");
            $query->execute(array($casting->getIdFilm(), $casting->getIdVip(), $casting->getIdCasting()));
        }

        public function delete(Casting $casting)
        {
            $query = $this->_bdd->prepare("DELETE FROM casting WHERE idcasting = ?");
            $query->execute(array($casting->getIdCasting()));
        }

        public function deleteByFilm($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM casting WHERE idfilm = ?");
            $query->execute(array($id));
        }

        public function deleteByActeur($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM casting WHERE idvip = ?");
            $query->execute(array($id));
        }

        public function getBy(Film $film, Vip $vip)
        {
            $castings = [];

            $query = $this->_bdd->prepare("SELECT idcasting FROM casting WHERE idfilm = ? AND idvip = ?");
            $query->execute(array($film->getIdFilm(), $vip->getIdVip()));

            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $castings[] = new Casting($donnees);
            }

            return $castings;
        }

        public function getId($idFilm, $idVip)
        {
            $query = $this->_bdd->prepare("SELECT idcasting AS id FROM casting WHERE idFilm = ? AND idVip = ?");
            $query->execute(array($idFilm, $idVip));
            $result = $query->fetch();
            $result = intval($result['id']);
            return $result;
        }

    }      

?>