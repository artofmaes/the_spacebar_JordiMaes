<?php
namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures implements DependentFixtureInterface
{
    private static $articleTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];
    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];
    private static $articleAuthors = [
        'Mike Ferengi',
        'Mike Wazowski',
        'Amy Oort',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class,10,function (Article $article, $count) use($manager){

            $article->setTitle($this->faker->randomElement(self::$articleTitles))
            ->setContent(<<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow, lorem proident …
Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck fugiat.
EOF
            );

            if ( $this->faker->boolean(70) ){
                $article->setPublished($this->faker->dateTimeBetween('-100 days','-1 days'));
            }

            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount( $this->faker->numberBetween(5,100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));

            /**
             * @var Tag[] $tags
             */
            $tags= $this->getRandomReferences(Tag::class,$this->faker->numberBetween(0,5));
            foreach ($tags as $tag){
                $article->addTag($tag);

            }

        });
        $manager->flush();
    }

    public function getDependencies()
    {
        return[TagFixture::class];
    }

}
