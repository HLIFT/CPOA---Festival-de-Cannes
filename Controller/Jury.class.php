<?php
    class Jury {
        
        private $_idJury;
        private $_libelle;



        function __construct($donnees){
            $this->hydrate($donnees);
        }

        function hydrate(array $donnees){
            foreach($donnees as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($this, $method)){
                    $this->$method($value);
                }

            }
        }

        function getIdJury(){
            return $this->_idVip;
        }

        function getLibelle(){
            return $this->_libelle;
        }

        
        function setIdJury($idjury){
            $idjury = (int) $idjury;

            if($idjury > 0){
                $this->_idJury = $idjury;
            }

        }

        function setLibelle($libelle){
            if(is_string($libelle))
            {
                $this->_libelle = $libelle;
            }
        }
    }