<?php

namespace INCES\ComedorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Usuario")
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cedula;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ncarnet;

    /**
     * @ORM\Column(type="boolean", nullable="true")
     */
    private $a_i;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $correo;

    /**
     * @ORM\Column(type="string", length=255, nullable="true")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Rol")
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="id")
     */
    private $rol;

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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    }

    /**
     * Get cedula
     *
     * @return string
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set ncarnet
     *
     * @param string $ncarnet
     */
    public function setNcarnet($ncarnet)
    {
        $this->ncarnet = $ncarnet;
    }

    /**
     * Get ncarnet
     *
     * @return string
     */
    public function getNcarnet()
    {
        return $this->ncarnet;
    }

    /**
     * Set a_i
     *
     * @param boolean $aI
     */
    public function setAI($aI)
    {
        $this->a_i = $aI;
    }

    /**
     * Get a_i
     *
     * @return boolean
     */
    public function getAI()
    {
        return $this->a_i;
    }

    /**
     * Set correo
     *
     * @param string $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set rol
     *
     * @param INCES\ComedorBundle\Entity\Rol $rol
     */
    public function setRol(\INCES\ComedorBundle\Entity\Rol $rol)
    {
        $this->rol = $rol;
    }

    /**
     * Get rol
     *
     * @return INCES\ComedorBundle\Entity\Rol
     */
    public function getRol()
    {
        return $this->rol;
    }
    public function __tostring(){
        return $this->nombre. " " . $this->apellido;
    }
}