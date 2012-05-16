<?php

namespace INCES\ComedorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INCES\ComedorBundle\Entity\UsuarioMenu
 */
class UsuarioMenu
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var INCES\ComedorBundle\Entity\Usuario
     */
    private $usuario;

    /**
     * @var INCES\ComedorBundle\Entity\Menu
     */
    private $menu;


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
     * Set usuario
     *
     * @param INCES\ComedorBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\INCES\ComedorBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return INCES\ComedorBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set menu
     *
     * @param INCES\ComedorBundle\Entity\Menu $menu
     */
    public function setMenu(\INCES\ComedorBundle\Entity\Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Get menu
     *
     * @return INCES\ComedorBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
    /**
     * @var datetime $dia
     */
    private $dia;


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
}