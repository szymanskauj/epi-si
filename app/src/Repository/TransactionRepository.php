<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Transaction;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository class for the Transaction entity.
 *
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * Finds transactions by wallet.
     *
     * @param Wallet $wallet The wallet entity
     *
     * @return array The list of transactions
     */
    public function findByWallet(Wallet $wallet): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.wallet = :wallet')
            ->setParameter('wallet', $wallet)
            ->orderBy('t.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds transactions by wallet.
     *
     * @param Wallet   $wallet   The wallet entity
     * @param Category $category Category
     *
     * @return array The list of transactions
     */
    public function findByWalletAndCategory(Wallet $wallet, Category $category): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.wallet = :wallet')
            ->andWhere('t.category = :category')
            ->setParameter('wallet', $wallet)
            ->setParameter('category', $category)
            ->orderBy('t.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds transactions by wallet since days.
     *
     * @param Wallet $wallet The wallet entity
     * @param int    $days   how many days back
     *
     * @return array The list of transactions
     */
    public function findByWalletSinceDays(Wallet $wallet, int $days): array
    {
        $date = new \DateTime();
        $date->modify("-$days days");

        return $this->createQueryBuilder('t')
            ->andWhere('t.wallet = :wallet')
            ->andWhere('t.createdAt > :date')
            ->setParameter('wallet', $wallet)
            ->setParameter('date', $date)
            ->orderBy('t.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds a transaction by its ID.
     *
     * @param int $id The transaction ID
     *
     * @return Transaction|null The transaction entity
     */
    public function findById(int $id): ?Transaction
    {
        return $this->find($id);
    }

    /**
     * Checks if a category is used in any transaction.
     *
     * @param Category $category The category entity
     *
     * @return bool True if the category is used, false otherwise
     */
    public function isCategoryUsed(Category $category): bool
    {
        try {
            $count = $this->createQueryBuilder('t')
                ->select('count(t.id)')
                ->where('t.category = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return false;
        }

        return $count > 0;
    }

    /**
     * Save entity.
     *
     * @param Transaction $transaction Transaction entity
     */
    public function save(Transaction $transaction): void
    {
        $this->getEntityManager()->persist($transaction);
        $this->getEntityManager()->flush();
    }

    /**
     * Delete entity.
     *
     * @param Transaction $transaction Transaction entity
     */
    public function delete(Transaction $transaction): void
    {
        $this->getEntityManager()->remove($transaction);
        $this->getEntityManager()->flush();
    }
}
