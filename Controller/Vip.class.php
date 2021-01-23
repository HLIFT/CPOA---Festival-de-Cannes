<?php
    class Vip {
        private $_idVip;
        private $_idNpec;
        private $_idJury;
        private $_prenom;
        private $_nom;
        private $_fonction;
        private $_photo;
        private $_nationalite;
        private $_coeffImportance;
        private $_compagnon;


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

        function getIdVip(){
            return $this->_idVip;
        }

        function getIdNpec(){
            return $this->_idNpec;
        }

        function getIdJury(){
            return $this->_idJury;
        }

        function getPrenom(){
            return $this->_prenom;
        }

        function getNom(){
            return $this->_nom;
        }

        function getFonction(){
            return $this->_fonction;
        }

        function getPhoto(){
            return $this->_photo;
        }

        function getNationalite(){
            return $this->_nationalite;
        }

        function getCoeffImportance(){
            return $this->_coeffImportance;
        }

        function getCompagnon(){
            return $this->_compagnon;
        }



        function setIdVip($idVip){
            $idVip = (int) $idVip;

            if($idVip > 0){
                $this->_idVip = $idVip;
            }

        }

        function setIdNpec($idNpec){
            $idNpec = (int) $idNpec;

            if($idNpec > 0){
                $this->_idNpec = $idNpec;
            }

        }

        function setIdJury($idjury){
            $idjury = (int) $idjury;

            if($idjury > 0){
                $this->_idJury = $idjury;
            }

        }

        function setPrenom($prenom){
            if(is_string($prenom)){
                $this->_prenom = $prenom;
            }

        }

        function setNom($nom){
            if(is_string($nom)){
                $this->_nom = $nom;
            }

        }

        function setFonction($fonction){
            if(is_string($fonction)){
                $this->_fonction = $fonction;
            }

        }

        function setPhoto($photo){
            if(is_string($photo)){
                $this->_photo = $photo;
            }

        }

        function setNationalite($nationalite){
            if(is_string($nationalite)){
                $this->_nationalite = $nationalite;
            }

        }

        function setCoeffImportance($coeffImportance){
            $coeffImportance = (int) $coeffImportance;

            if($coeffImportance > 0){
                $this->_coeffImportance = $coeffImportance;
            }

        }

        function setCompagnon($compagnon){
            if(is_string($compagnon)){
                $this->_compagnon = $compagnon;
            }

        }









}
