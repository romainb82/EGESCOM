<?php

namespace Pap\Gescom\Model\manager\Entity;

class LoginEntity
{
    private $_name;
    private $_mail;

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
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->_mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail): void
    {
        $this->_mail = $mail;
    }
}