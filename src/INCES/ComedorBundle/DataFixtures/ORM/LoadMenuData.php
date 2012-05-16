<?php
// src/INCES/ComedorBundle/DataFixtures/ORM/LoadMenuData.php
namespace INCES\ComedorBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use INCES\ComedorBundle\Entity\Menu;

class LoadmenuData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $menu = new Menu();
        $menu -> setSeco('Arroz con pollo');
        $menu -> setSopa('Caldo de pollo');
        $menu -> setDia(new \DateTime('now'));

        $manager->persist($menu);
        $manager->flush();

        $this->addReference('menu-user', $menu);
    }

    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
