<?php
// src/INCES/ComedorBundle/DataFixtures/ORM/LoadUsuarioData.php
namespace INCES\ComedorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use INCES\ComedorBundle\Entity\Usuario;

class LoadUsuarioData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $usuario = new Usuario();
        $usuario -> setNombre('Gabriel');
        $usuario -> setApellido('Muñumel');
        $usuario -> setNcarnet(0437332);
        $usuario -> setAI(false);
        $usuario -> setCorreo('gabrielmunumel@gmail.com');
        $usuario -> setRol($manager->merge($this->getReference('rol-user')));

        $manager->persist($usuario);
        $manager->flush();

        $this->addReference('user-menu', $usuario);
    }

    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
