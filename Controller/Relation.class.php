<?php

class Relation
{
    private $_idRelation;
    private $_idEchange;
    private $_idAction;

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

    function getIdRelation()
    {
        return $this->_idRelation;
    }

    function getIdEchange()
    {
        return $this->_idEchange;
    }

    function getIdAction()
    {
        return $this->_idAction;
    }

    // ----- Setters ----- //

    function setIdRelation($idRelation)
    {
        $idRelation = (int) $idRelation;

        if($idRelation > 0)
        {
            $this->_idRelation = $idRelation;
        }
    }

    function setIdEchange($idEchange)
    {
        $idEchange = (int) $idEchange;

        if($idEchange > 0)
        {
            $this->_idEchange = $idEchange;
        }
    }

    function setIdAction($idAction)
    {
        $idAction = (int) $idAction;

        if($idAction > 0)
        {
            $this->_idAction = $idAction;
        }
    }
}