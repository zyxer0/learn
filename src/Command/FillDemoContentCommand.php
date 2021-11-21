<?php

namespace App\Command;

use App\Entity\AmountUnit;
use App\Entity\Author;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Faker\Generator;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Faker\Factory;
use Doctrine\ORM\EntityManagerInterface;

class FillDemoContentCommand extends Command
{
    private ContainerInterface $container;
    private Generator $faker;

    public function __construct(ContainerInterface $container, string $name = null)
    {
        $this->container = $container;
        parent::__construct($name);
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:fill-demo-content';

    protected function configure(): void
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $recipesNum = 1000;

        $progressBar = new ProgressBar($output, $recipesNum);
        $faker = $this->faker;

        $progressBar->start();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->container->get('doctrine')->getManager();

        $ingredientsFunctions = [
            'dairyName',
            'vegetableName',
            'fruitName',
            'meatName',
            'sauceName',
        ];

        $units = [];
        foreach (['pc', 'gram', 'liter'] as $unit) {
            $units[] = $amountUnit = new AmountUnit();
            $amountUnit->setName($unit);
            $entityManager->persist($amountUnit);
        }

        // Авторов делаем в десять раз меньше чем рецептов
        $authors = [];
        $i = 0;
        while ($i++ < $recipesNum/10) {
            $author = new Author();
            $authors[] = $author;
            $author->setName($faker->name());
            $author->setLastName($faker->lastName());
            $author->setEmail($faker->email());
            if (rand(1, 10) != 1) {
                $author->setPhone($faker->phoneNumber());
            }
            $entityManager->persist($author);
        }

        $i = 0;
        while ($i++ < $recipesNum) {
            $recipe = new Recipe();
            $recipe->setName($faker->foodName());
            // Время приготовления в минутах с округлением до 10 минут
            $recipe->setCookingTime(round(rand(10, 120)/10)*10);
            $recipe->setAuthor($authors[rand(0, count($authors)-1)]);
            $recipe->setDescription($faker->text(1000));

            $entityManager->persist($recipe);

            // Добавляем ингредиенты
            $ingredientsNum = rand(5, 15);
            for ($i2 = 1; $i2 <= $ingredientsNum; $i2++) {
                $ingredient = new Ingredient();
                $ingredientFunction = $ingredientsFunctions[rand(0, count($units)-1)];
                $ingredient->setName($faker->$ingredientFunction());
                $ingredient->setAmount(rand(1, 100));
                $ingredient->setAmountUnit($units[rand(0, count($units)-1)]);
                $ingredient->setRecipe($recipe);
                $entityManager->persist($ingredient);
            }
            $entityManager->flush();
            $progressBar->advance();
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }
}