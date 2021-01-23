<?php

class Staff
{
    private $_idStaff;
    private $_prenom;
    private $_nom;
    private $_fonction;
    private $_login;
    private $_password;

    function __construct($donnees)
    {
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

    function getIdStaff()
    {
        return $this->_idStaff;
    }

    function getPrenom()
    {
        return $this->_prenom;
    }

    function getNom()
    {
        return $this->_nom;
    }

    function getFonction()
    {
        return $this->_fonction;
    }

    function getLogin()
    {
        return $this->_login;
    }

    function getPassword()
    {
        return $this->_password;
    }

    function setIdStaff($idStaff)
    {
        $idStaff = (int) $idStaff;

        if($idStaff > 0){
            $this->_idStaff = $idStaff;
        }
    }

    function setPrenom($prenom)
    {
        if(is_string($prenom))
        {
            $this->_prenom = $prenom;
        }
    }

    function setNom($nom)
    {
        if(is_string($nom))
        {
            $this->_nom = $nom;
        }
    }

    function setFonction($fonction)
    {
        if(is_string($fonction))
        {
            $this->_fonction = $fonction;
        }
    }

    function setLogin($login)
    {
        if(is_string($login))
        {
            $this->_login = $login;
        }
    }

    function setPassword($password)
    {
        if(is_string($password))
        {
            $this->_password = $password;
        }
    }
}