<?php

namespace Pap\Gescom\Model\manager\Entity;

class DeveloppeurEntity{
    private $idDev;
    private $prenom;
    private $timespent;

    public function __construct(array $tabDonnees)
    {
        if (!empty($tabDonnees)) {
            $this->hydrateAuto($tabDonnees);
        }
    }

    private function hydrateAuto(array $tabDonnees)
    {
        foreach ($tabDonnees as $strKey => $strValue) {
            $objMethod = 'set' . ucfirst(strtolower($strKey));
            if (method_exists($this, $objMethod)) {
                $this->$objMethod($strValue);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getidDev()
    {
        return $this->_idDev;
    }

    /**
     * @param mixed $idDev
     */
    public function setidDev($idDev): void
    {
        $this->_idDev = $idDev;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->_prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->_prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getTimespent()
    {
        return $this->_timespent;
    }

    /**
     * @param mixed $timespent
     */
    public function setTimespent($timespent): void
    {
        $this->_timespent = $timespent;
    }

}