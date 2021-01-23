<?php

    class VipManager
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

            $query = $this->_bdd->prepare("SELECT * FROM vip WHERE idvip = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Vip($donnees);
        }

        public function add(Vip $vip)
        {
            $query = $this->_bdd->prepare("INSERT INTO vip(idnpec,prenom,nom,fonction,photo,nationalite,coeffimportance,compagnon) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $query->execute(array($vip->getIdNpec(), $vip->getPrenom(), $vip->getNom(), $vip->getFonction(), $vip->getPhoto(), $vip->getNationalite(), $vip->getCoeffImportance(), $vip->getCompagnon()));

            $vip->hydrate([
                'idvip' => $this->_bdd->lastInsertId(),
                'idnpec' => $vip->getPrenom(),
                'prenom' => $vip->getPrenom(),
                'nom' => $vip->getNom(),
                'fonction' => $vip->getFonction(),
                'photo' => $vip->getPhoto(),
                'nationalite' => $vip->getNationalite(),
                'coeffimportance' => $vip->getCoeffImportance(),
                'compagnon' => $vip->getCompagnon()
            ]);
        }

        public function update(Vip $vip)
        {
            $query = $this->_bdd->prepare("UPDATE vip SET idnpec = ?, prenom = ?, nom = ?, fonction = ?, photo = ?, nationalite = ?, coeffimportance = ?, compagnon = ? WHERE idvip = ?");
            $query->execute(array($vip->getIdNpec(), $vip->getPrenom(), $vip->getNom(), $vip->getFonction(), $vip->getPhoto(), $vip->getNationalite(), $vip->getCoeffImportance(), $vip->getCompagnon(), $vip->getIdVip()));
        }

        public function delete(Vip $vip)
        {
            $query = $this->_bdd->prepare("DELETE FROM vip WHERE idvip = ?");
            $query->execute(array($vip->getIdVip()));
        }

        function getVips()
        {
            $query = $this->_bdd->prepare("SELECT * FROM vip ORDER BY nom ASC");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function getVipsFilm($id)
        {
            $query = $this->_bdd->prepare("SELECT vip.idvip, prenom, nom FROM vip LEFT OUTER JOIN casting ON vip.idvip = casting.idvip WHERE idfilm = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

        public function getVipInEchange(Echange $echange)
        {
            $vips = [];

            $query = $this->_bdd->prepare("SELECT vip.idvip, prenom, nom FROM vip LEFT OUTER JOIN echange ON vip.idvip = echange.idvip WHERE idechange = ?");
            $query->execute(array($echange->getIdEchange()));
            
            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $vips[] = new Vip($donnees);
            }

            return $vips;
        }

        public function exist($prenom, $nom)
        {
            $query = $this->_bdd->prepare("SELECT COUNT(*) as exist FROM vip WHERE prenom = ? AND nom = ?");
            $query->execute(array($prenom, $nom));
            $result = $query->fetch();
            $result = intval($result['exist']);
            return $result;
        }
    }      

?>