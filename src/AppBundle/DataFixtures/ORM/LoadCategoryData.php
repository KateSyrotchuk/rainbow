<?php
/**
 * Created by PhpStorm.
 * User: kate
 * Date: 17.02.16
 * Time: 17:14
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setTitle('site.category.houses');
        $category->setUrl("/show_type/Дома");
        $this->setReference("houses", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle('site.category.flats');
        $category->setUrl("/show_type/Квартиры");
        $this->setReference("flats", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle('site.category.steads');
        $category->setUrl("/show_type/Участки");
        $this->setReference("steads", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle('site.category.rent_of_dwelling');
        $category->setUrl("/show_rent");
        $this->setReference("rent", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle('site.category.commerces');
        $category->setUrl("/show_type/Коммерция");
        $this->setReference("commerce", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.house.in_town");
        $category->setUrl("show_category");
        //$category->setUrl("{{ path('show_category', {'slug': link.title}) }}");
        $category->setParent($this->getReference("houses"));
        $this->setReference("category6", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.house.outside");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("houses"));
        $this->setReference("category7", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.flat.room");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("flats"));
        $this->setReference("category1", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.flat.studio");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("flats"));
        $this->setReference("category2", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.flat.two_rooms");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("flats"));
        $this->setReference("category3", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.flat.three_rooms");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("flats"));
        $this->setReference("category4", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.flat.multiroom");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("flats"));
        $this->setReference("category5", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.stead.cottage");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("steads"));
        $this->setReference("category8", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.stead.in_town");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("steads"));
        $this->setReference("category9", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.stead.outside");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("steads"));
        $this->setReference("category10", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.commerce.rent");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("commerce"));
        $this->setReference("category11", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.commerce.buy");
        $category->setUrl("show_category");
        $category->setParent($this->getReference("commerce"));
        $this->setReference("category12", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.rent.houses");
        $category->setUrl("show_rent");
        $category->setParent($this->getReference("rent"));
        $this->setReference("category13", $category);
        $manager->persist($category);

        $category = new Category();
        $category->setTitle("site.category.rent.flats");
        $category->setUrl("show_rent");
        $category->setParent($this->getReference("rent"));
        $this->setReference("category14", $category);
        $manager->persist($category);

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}