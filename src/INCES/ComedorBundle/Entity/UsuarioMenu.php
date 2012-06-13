<?php

namespace INCES\ComedorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="UsuarioMenu")
 */
class UsuarioMenu
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dia;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="usuario_menus")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="usuario_menus")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id")
     */
    private $menu;

    public function __construct()
    {
        $this->dia = new \DateTime('now');
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
     * Set dia
     *
     * @param date $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * Get dia
     *
     * @return date
     */
    public function getDia()
    {
        return $this->dia;
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
}