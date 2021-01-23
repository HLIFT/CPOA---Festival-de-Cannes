<?php

    class StaffManager
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

            $query = $this->_bdd->prepare("SELECT * FROM staff WHERE idstaff = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Staff($donnees);
        }

        public function add(Staff $staff)
        {
            $query = $this->_bdd->prepare("INSERT INTO staff(prenom, nom, fonction, login, password) VALUES(?, ?, ?, ?, ?)");
            $query->execute(array($staff->getPrenom(), $staff->getNom(), $staff->getFonction(), $staff->getLogin(), $staff->getPassword()));

            $staff->hydrate([
                'idstaff' => $this->_bdd->lastInsertId(),
                'prenom' => $staff->getPrenom(),
                'nom' => $staff->getNom(),
                'fonction' => $staff->getFonction(),
                'login' => $staff->getLogin(),
                'password' => $staff->getPassword()
            ]);
        }

        function update(Staff $staff)
        {
            $query = $this->_bdd->prepare("UPDATE staff SET login = ?, password = ? WHERE idstaff = ?");
            $query->execute(array($staff->getLogin(), $staff->getPassword(), $staff->getIdStaff()));
        }

        function getStaffs()
        {
            $query = $this->_bdd->prepare("SELECT * FROM staff");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function valid($login, $password)
        {
            $query = $this->_bdd->prepare("SELECT * FROM staff WHERE login = ? AND password = ? LIMIT 1");
            $query->execute(array($login, $password));
            $result = $query->fetchAll();
            return $result;
        }

        public function exist($login)
        {
            $query = $this->_bdd->prepare("SELECT * FROM staff WHERE login = ? LIMIT 1");
            $query->execute(array($login));
            $result = $query->fetchAll();
            return $result;
        }

        public function getId($login)
        {
            $query = $this->_bdd->prepare("SELECT idstaff AS id FROM staff WHERE login = ? LIMIT 1");
            $query->execute(array($login));
            $result = $query->fetch();
            $result = intval($result['id']);
            return $result;
        }

        public function getByLogin($login)
        {
            $query = $this->_bdd->prepare("SELECT * FROM staff WHERE login = ? LIMIT 1");
            $query->execute(array($login));
            $result = $query->fetch();
            $result = count($result);
            return $result;
        }
    }      

?>