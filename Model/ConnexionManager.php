<?php
  class ConnexionManager {

    private $_bdd;

    function __construct($host,$db,$user,$pwd){

     $this->_bdd = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$user,$pwd);

    }

    function getDB(){
      return $this->_bdd;
    }
  }
