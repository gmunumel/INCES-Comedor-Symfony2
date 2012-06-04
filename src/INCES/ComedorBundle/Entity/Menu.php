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

    /**
     * @var string $salado
     */
    private $salado;

    /**
     * @var string $jugo
     */
    private $jugo;

    /**
     * @var string $ensalada
     */
    private $ensalada;

    /**
     * @var string $postre
     */
    private $postre;


    /**
     * Set salado
     *
     * @param string $salado
     */
    public function setSalado($salado)
    {
        $this->salado = $salado;
    }

    /**
     * Get salado
     *
     * @return string 
     */
    public function getSalado()
    {
        return $this->salado;
    }

    /**
     * Set jugo
     *
     * @param string $jugo
     */
    public function setJugo($jugo)
    {
        $this->jugo = $jugo;
    }

    /**
     * Get jugo
     *
     * @return string 
     */
    public function getJugo()
    {
        return $this->jugo;
    }

    /**
     * Set ensalada
     *
     * @param string $ensalada
     */
    public function setEnsalada($ensalada)
    {
        $this->ensalada = $ensalada;
    }

    /**
     * Get ensalada
     *
     * @return string 
     */
    public function getEnsalada()
    {
        return $this->ensalada;
    }

    /**
     * Set postre
     *
     * @param string $postre
     */
    public function setPostre($postre)
    {
        $this->postre = $postre;
    }

    /**
     * Get postre
     *
     * @return string 
     */
    public function getPostre()
    {
        return $this->postre;
    }
}