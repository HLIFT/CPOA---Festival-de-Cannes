<?php

    class RelationManager
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

        public function add(Relation $relation)
        {
            $query = $this->_bdd->prepare("INSERT INTO relation(idechange, idaction) VALUES(?, ?)");
            $query->execute(array($relation->getIdEchange(), $relation->getIdAction()));

            $relation->hydrate([
                'idrelation' => $this->_bdd->lastInsertId(),
                'idechange' => $relation->getIdEchange(),
                'idaction' => $relation->getIdAction()
            ]);
        }

        public function update(Relation $relation)
        {
            $query = $this->_bdd->prepare("UPDATE relation SET idechange = ?, idaction = ? WHERE idrelation = ?");
            $query->execute(array($relation->getIdEchange(), $relation->getIdAction(), $relation->getIdRelation()));
        }

        public function delete(Relation $relation)
        {
            $query = $this->_bdd->prepare("DELETE FROM relation WHERE idrelation = ?");
            $query->execute(array($relation->getIdRelation()));
        }

        public function deleteByEchange($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM relation WHERE idechange = ?");
            $query->execute(array($id));
        }

        public function deleteByAction($id)
        {
            $query = $this->_bdd->prepare("DELETE FROM relation WHERE idaction = ?");
            $query->execute(array($id));
        }

        public function getBy(Echange $echange, Action $action)
        {
            $relations = [];

            $query = $this->_bdd->prepare("SELECT idrelation FROM relation WHERE idechange = ? AND idaction = ?");
            $query->execute(array($echange->getIdEchange(), $action->getIdAction()));

            while ($donnees = $query->fetch(PDO::FETCH_ASSOC))
            {
                $relations[] = new Relation($donnees);
            }

            return $relations;
        }

        public function getId($idEchange, $idAction)
        {
            $query = $this->_bdd->prepare("SELECT idrelation AS id FROM relation WHERE idechange = ? AND idaction = ?");
            $query->execute(array($idEchange, $idAction));
            $result = $query->fetch();
            $result = intval($result['id']);
            return $result;
        }

        function getActionWithEchange($id)
        {
            $query = $this->_bdd->prepare("SELECT idaction FROM relation WHERE idechange = ?");
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        }

        function actionExiste($idEchange)
        {
            $query = $this->_bdd->prepare("SELECT * from relation WHERE idechange = ? LIMIT 1");
            $query->execute(array($idEchange));
            $result = $query->fetch();
            return $result;
        }
    }      

?>