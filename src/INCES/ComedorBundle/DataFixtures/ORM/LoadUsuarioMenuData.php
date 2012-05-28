<?php
// src/INCES/ComedorBundle/DataFixtures/ORM/LoadUsuariouserMenuData.php
namespace INCES\ComedorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use INCES\ComedorBundle\Entity\UsuarioMenu;

class LoadUsuarioMenuData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userMenu = new UsuarioMenu();
        $userMenu -> setUsuario($manager->merge($this->getReference('user-menu')));
        $userMenu -> setMenu($manager->merge($this->getReference('menu-user')));
        $userMenu -> setDia(new \DateTime ('now'));

        $manager->persist($userMenu);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}

