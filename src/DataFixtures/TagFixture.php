<?php

namespace App\DataFixtures;


use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends BaseFixtures
{
    public function loadData(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $this->createMany(Tag::class,10,function(Tag $tag){
            $tag = new Tag();
            $tag->setName($this->faker->realText(20));
        });

        $manager->flush();
    }
}
