<?php

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture;
use App\Entity\Task;
use Doctrine\Common\Persistence\ObjectManager;

class TaskFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_tasks', function() {
            $task = new Task();
            $task->setDatum($this->faker->dateTimeBetween('-1 months', '+3 months'))
                ->setOmschr($this->faker->city . " Barbecue");

            return $task;
        });

        $manager->flush();
    }
}


