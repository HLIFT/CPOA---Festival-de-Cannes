<?php

class Action
{
    private $_idAction;
    private $_contenu;
    private $_effectuee;

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

    function getIdAction()
    {
        return $this->_idAction;
    }

    function getContenu()
    {
        return $this->_contenu;
    }

    function getEffectuee()
    {
        return $this->_effectuee;
    }

    // ----- Setters ----- //

    function setIdAction($idAction)
    {
        $idAction = (int) $idAction;

        if($idAction > 0)
        {
            $this->_idAction = $idAction;
        }
    }

    function setContenu($contenu)
    {
        if(is_string($contenu))
        {
            $this->_contenu = $contenu;
        }
    }

    function setEffectuee($effectuee)
    {
        $effectuee = (int) $effectuee;

        if($effectuee == 0 || $effectuee == 1)
        {
            $this->_effectuee = $effectuee;
        }
    }
}