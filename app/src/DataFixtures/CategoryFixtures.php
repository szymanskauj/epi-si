<?php

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Entity\Category;

/**
 * Class CategoryFixtures
 *
 * This class is responsible for loading category data fixtures into the database.
 */
#[AllowDynamicProperties] class CategoryFixtures extends AbstractBaseFixtures
{
    /**
     * Load category data fixtures.
     */
    public function loadData(): void
    {
        $this->createMany(4, 'categories', function (int $i) {
            $category = new Category();
            $category->setTitle($this->faker->unique()->word);
            $category->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $category->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            return $category;
        });

        $this->manager->flush();
    }
}
