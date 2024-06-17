<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 *
 */

namespace App\DataFixtures;

use AllowDynamicProperties;
use App\Entity\Transaction;
use App\Entity\Wallet;
use DateTimeImmutable;

/**
 * Class WalletFixtures
 *
 * Loads wallet and transaction data fixtures into the database.
 */
#[AllowDynamicProperties] class WalletFixtures extends AbstractBaseFixtures
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * This method creates 10 wallet entities, each with 10 associated transaction entities,
     * and persists them to the database.
     */
    protected function loadData(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $wallet = new Wallet();
            $wallet->setName($this->faker->word);
            $wallet->setBalance($this->faker->randomFloat(2, 1, 1000));
            $wallet->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $wallet->setUpdatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $this->manager->persist($wallet);

            for ($j = 0; $j < 10; ++$j) {
                $transaction = new Transaction();
                $transaction->setAmount($this->faker->randomFloat(2, 1, 1000));
                $transaction->setCreatedAt(
                    DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
                );
                $transaction->setUpdatedAt(
                    DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
                );
                $transaction->setWallet($wallet);
                $category = $this->getRandomReference('categories');
                $transaction->setCategory($category);
                $this->manager->persist($transaction);
            }
        }
        $this->manager->flush();
    }
}
