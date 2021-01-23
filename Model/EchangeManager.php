<?php

    class EchangeManager
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

            $query = $this->_bdd->prepare("SELECT * FROM echange WHERE idechange = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Echange($donnees);
        }

        function getEchanges()
        {
            $query = $this->_bdd->prepare("SELECT * FROM echange");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        function getEchangesWithVip($id)
        {
            $query = $this->_bdd->prepare("SELECT * FROM echange WHERE idvip = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

        function getEchangesWithStaff($id)
        {
            $query = $this->_bdd->prepare("SELECT * FROM echange WHERE idstaff = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

        public function add(Echange $echange)
        {
            $query = $this->_bdd->prepare("INSERT INTO echange(idvip, idstaff, contenu, date, moycom, heure) VALUES(?, ?, ?, ?, ?, ?)");
            $query->execute(array($echange->getIdVip(), $echange->getIdStaff(), $echange->getContenu(), $echange->getDate(), $echange->getMoyCom(), $echange->getHeure()));

            $echange->hydrate([
                'idechange' => $this->_bdd->lastInsertId(),
                'idvip' => $echange->getIdVip(),
                'idstaff' => $echange->getIdStaff(),
                'contenu' => $echange->getContenu(),
                'date' => $echange->getDate(),
                'moycom' => $echange->getMoyCom(),
                'heure' => $echange->getHeure()
            ]);
        }

        public function update(Echange $echange)
        {
            $query = $this->_bdd->prepare("UPDATE echange SET idvip = ?, idstaff = ?, contenu = ?, date = ?, moycom = ?, heure = ? WHERE idechange = ?");
            $query->execute(array($echange->getIdVip(), $echange->getIdStaff(), $echange->getContenu(), $echange->getDate(), $echange->getMoyCom(), $echange->getHeure(), $echange->getIdEchange()));
        }

        public function delete(Echange $echange)
        {
            $query = $this->_bdd->prepare("DELETE FROM echange WHERE idechange = ?");
            $query->execute(array($echange->getIdEchange()));
        }

    }      

?>