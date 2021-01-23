<?php
class PriseEnCharge
{

    private $_idNpec;
    private $_libelle;

    function __construct($donnees)
    {
        $this->hydrate($donnees);
    }

    function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    function getIdNpec()
    {
        return $this->_idNpec;
    }

    function getLibelle()
    {
        return $this->_libelle;
    }


    function setIdNpec($idNpec)
    {
        $idNpec = (int) $idNpec;

        if ($idNpec > 0) {
            $this->_idNpec = $idNpec;
        }
    }

    function setLibelle($libelle)
    {
        if (is_string($libelle)) {
            $this->_libelle = $libelle;
        }
    }
}
