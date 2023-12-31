<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Bezhanov\Faker\Provider\Commerce;
use Bezhanov\Faker\Provider\Device;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        try {
            $user = (new User(Uuid::v4()))
                ->setEmail("admin@admin.com")
                ->setPassword("admin")
            ;

            $manager->persist($user);
            $manager->flush();

        } catch (\Exception)
        {}

        for ($i = 0; $i < 2; $i++) {
            $rootData = Factory::create();
            $rootData->addProvider(new Commerce($rootData));

            $rootCategory = (new Category(Uuid::v4()))
                ->setName($rootData->department(4))
                ->setIsLastLevel(false)
            ;
            $manager->persist($rootCategory);

            for ($ii = 0; $ii < 5; $ii++) {
                $subData = Factory::create();
                $subData->addProvider(new Commerce($subData));

                $subCategory = (new Category(Uuid::v4()))
                    ->setName($subData->department(1))
                    ->setIsLastLevel(false)
                    ->setParent($rootCategory)
                ;
                $manager->persist($subCategory);

                // some empty categories
                for ($iii = 0; $iii < 10; $iii++) {
                    $subData2 = Factory::create();
                    $subData2->addProvider(new Commerce($subData));

                    $subCategory2 = (new Category(Uuid::v4()))
                        ->setName($subData2->category())
                        ->setIsLastLevel(true)
                        ->setParent($subCategory);
                    $manager->persist($subCategory2);
                }

                for ($iii = 0; $iii < 10; $iii++) {
                    $subData2 = Factory::create();
                    $subData2->addProvider(new Commerce($subData));

                    $subCategory2 = (new Category(Uuid::v4()))
                        ->setName($subData2->category())
                        ->setIsLastLevel(true)
                        ->setParent($subCategory)
                    ;
                    $manager->persist($subCategory2);

                    for($p = 0; $p < 20; $p++) {
                        $prodData = Factory::create();
                        $prodData->addProvider(new Commerce($prodData));
                        $prodData->addProvider(new Device($prodData));


                        $product = (new Product(Uuid::v4()))
                            ->setName($prodData->productName())
                            ->setBrand($prodData->deviceManufacturer())
                            ->setValue($prodData->randomFloat(2,1, 1000))
                            ->setCategory($subCategory2)
                        ;
                        $manager->persist($product);

                        if ($p % 10) {
                            $manager->flush();
                        }
                    }
                }
            }
        }
        $manager->flush();
    }
}
