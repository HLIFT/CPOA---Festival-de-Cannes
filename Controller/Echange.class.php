<?php

class Echange
{
    private $_idEchange;
    private $_idVip;
    private $_idStaff;
    private $_contenu;
    private $_date;
    private $_heure;
    private $_moyCom;

    function __construct($donnees)
    {
        $this->hydrate($donnees);
    }

    // ----- Hydrate ----- //

    public function hydrate(array $donnees)
    {

        foreach ($donnees as $key => $value) // Chaque champ est lu
        {
            // On récupère le nom du setter correspondant à l'attribut de la classe.
            $method = 'set'.ucfirst($key);
            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
                // On appelle le setter.
                $this->$method($value);
            }
        }
    }

    // ----- Getters ----- //

    function getIdEchange()
    {
        return $this->_idEchange;
    }

    function getIdVip()
    {
        return $this->_idVip;
    }

    function getIdStaff()
    {
        return $this->_idStaff;
    }

    function getContenu()
    {
        return $this->_contenu;
    }

    function getDate()
    {
        return $this->_date;
    }

    function getHeure()
    {
        return $this->_heure;
    }

    function getMoyCom()
    {
        return $this->_moyCom;
    }

    // ----- Setters ----- //

    function setIdEchange($idEchange)
    {
        $idEchange = (int) $idEchange;

        if($idEchange > 0)
        {
            $this->_idEchange = $idEchange;
        }
    }

    function setIdVip($idVip)
    {
        $idVip = (int) $idVip;
        $this->_idVip = $idVip;
    }

    function setIdStaff($idStaff)
    {
        $idStaff = (int) $idStaff;
        $this->_idStaff = $idStaff;
    }

    function setContenu($contenu)
    {
        if(is_string($contenu))
        {
            $this->_contenu = $contenu;
        }
    }

    function setDate($date)
    {
        if(is_string($date))
        {
            $this->_date = $date;
        }
    }

    function setHeure($heure)
    {
        if(is_string($heure))
        {
            $this->_heure = $heure;
        }
    }

    function setMoyCom($moyCom)
    {
        if(is_string($moyCom))
        {
            $this->_moyCom = $moyCom;
        }
    }

}