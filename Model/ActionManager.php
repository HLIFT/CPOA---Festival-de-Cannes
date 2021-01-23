<?php

    class ActionManager
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

            $query = $this->_bdd->prepare("SELECT * FROM action WHERE idaction = ?");
            $query->execute(array($id));
            $donnees = $query->fetch(PDO::FETCH_ASSOC);

            return new Action($donnees);
        }

        function getActions()
        {
            $query = $this->_bdd->prepare("SELECT * FROM action");
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function add(Action $action)
        {
            $query = $this->_bdd->prepare("INSERT INTO action(contenu, effectuee) VALUES(?, ?)");
            $query->execute(array($action->getContenu(), $action->getEffectuee()));

            $action->hydrate([
                'idaction' => $this->_bdd->lastInsertId(),
                'contenu' => $action->getContenu(),
                'effectuee' => $action->getEffectuee()
            ]);
        }

        public function update(Action $action)
        {
            $query = $this->_bdd->prepare("UPDATE action SET contenu = ?, effectuee = ? WHERE idaction = ?");
            $query->execute(array($action->getContenu(), $action->getEffectuee(), $action->getIdAction()));
        }

        public function delete(Action $action)
        {
            $query = $this->_bdd->prepare("DELETE FROM action WHERE idaction = ?");
            $query->execute(array($action->getIdAction()));
        }

        function getActionByEchange(Echange $echange)
        {
            $query = $this->_bdd->prepare("SELECT action.idaction, contenu, effectuee FROM action LEFT OUTER JOIN relation ON action.idaction = relation.idaction WHERE idechange = ?");
            $query->execute(array($echange->getIdEchange()));
            $result = $query->fetch();
            return $result;
        }


    }      

?>