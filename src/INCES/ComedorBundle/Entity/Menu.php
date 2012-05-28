<?php

namespace INCES\ComedorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INCES\ComedorBundle\Entity\Menu
 */
class Menu
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $seco
     */
    private $seco;

    /**
     * @var string $sopa
     */
    private $sopa;

    /**
     * @var datetime $dia
     */
    private $dia;

    /**
     * @var INCES\ComedorBundle\Entity\UsuarioMenu
     */
    private $usuario_menus;

    public function __construct()
    {
        $this->usuario_menus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set seco
     *
     * @param string $seco
     */
    public function setSeco($seco)
    {
        $this->seco = $seco;
    }

    /**
     * Get seco
     *
     * @return string
     */
    public function getSeco()
    {
        return $this->seco;
    }

    /**
     * Set sopa
     *
     * @param string $sopa
     */
    public function setSopa($sopa)
    {
        $this->sopa = $sopa;
    }

    /**
     * Get sopa
     *
     * @return string
     */
    public function getSopa()
    {
        return $this->sopa;
    }

    /**
     * Set dia
     *
     * @param datetime $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * Get dia
     *
     * @return datetime
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Add usuario_menus
     *
     * @param INCES\ComedorBundle\Entity\UsuarioMenu $usuarioMenus
     */
    public function addUsuarioMenu(\INCES\ComedorBundle\Entity\UsuarioMenu $usuarioMenus)
    {
        $this->usuario_menus[] = $usuarioMenus;
    }

    /**
     * Get usuario_menus
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUsuarioMenus()
    {
        return $this->usuario_menus;
    }

}
