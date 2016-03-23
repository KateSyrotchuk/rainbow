<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Estate;
use AppBundle\Entity\File;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadEstateData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i <= 200; $i++) {
            $estate = new Estate();
            $estate->setTitle($faker->sentence);
            $estate->setDescription($faker->sentence);
            $estate->setPrice($faker->numberBetween(10000, 500000));
            $estate->setCreatedBy('user_manager'.rand(0,2));
            $estate->setDistrict($this->getReference('district' . rand(1, 10)));

            $exclusive = rand(1, 10);
            if ($exclusive == 10) {
                $estate->setExclusive(true);
            }
            for ($k = 1; $k <= 5; $k++) {
                $file = new File();
                $file->setEstate($estate);
                $estate->addFile($file);
                $file->setMimeType('image/jpeg');
                $file->setName(md5(uniqid('sdfadf')) . '.jpg');
                $file->setSize('100000');
                $file->setPath("images/estates/foto" . rand(1, 9) . ".jpg");
                $manager->persist($file);
            }
            for ($j = 1; $j <= 5; $j++) {
                $comment = new Comment();
                $comment->setEstate($estate);
                $estate->addComment($comment);
                $comment->setContent($faker->sentence);
                $comment->setCreatedBy('user_admin');
                $comment->setEnabled(true);
                $manager->persist($comment);
            }
            // flats - 40%
            // set category
            // for rent - 20%
            $quart = rand(0, 9);
            if ($quart <= 3) {
                $cat = rand(1, 5);
                $estate->setCategory($this->getReference('category' . $cat));
                $countFloors = rand(4, 16);
                $estate->setFloor(array('floor' => rand(1, $countFloors), 'count_floor' => $countFloors));
                $floor = $estate->getFloor();
                if (($floor['floor'] == 1) || ($floor['floor'] == $floor['count_floor'])) {
                    $estate->setFirstLastFloor(true);
                } else {
                    $estate->setFirstLastFloor(false);
                }
            } elseif ($quart == 4 || $quart == 5) {
                $cat = rand(13, 14);
                $estate->setCategory($this->getReference('category' . $cat));
            } else {
                $cat = rand(6, 12);
                $estate->setCategory($this->getReference('category' . $cat));
            }

            $manager->persist($estate);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
