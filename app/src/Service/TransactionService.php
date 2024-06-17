<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Service;

use App\Entity\Wallet;
use App\Repository\TransactionRepository;
use App\Entity\Transaction;

/**
 * Transaction Service.
 */
class TransactionService implements TransactionServiceInterface
{
    /**
     * Transaction repository.
     */
    private TransactionRepository $transactionRepository;

    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Constructor.
     *
     * @param TransactionRepository    $transactionRepository TransactionRepository
     * @param CategoryServiceInterface $categoryService       CategoryServiceInterface
     */
    public function __construct(TransactionRepository $transactionRepository, CategoryServiceInterface $categoryService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->categoryService = $categoryService;
    }

    /**
     * Find transactions by wallet.
     *
     * @param Wallet $wallet     Wallet
     * @param int    $categoryId Category Id
     * @param int    $days       Days
     *
     * @return array transactions list
     */
    public function findByWallet(Wallet $wallet, int $categoryId, int $days): array
    {
        $category = $this->categoryService->findById($categoryId);
        if (null !== $category) {
            return $this->transactionRepository->findByWalletAndCategory($wallet, $category);
        }

        if ($days > 0) {
            return $this->transactionRepository->findByWalletSinceDays($wallet, $days);
        }

        return $this->transactionRepository->findByWallet($wallet);
    }

    /**
     * Find transaction by ID.
     *
     * @param int $id id
     *
     * @return Transaction|null Transaction
     */
    public function findById(int $id): ?Transaction
    {
        return $this->transactionRepository->findById($id);
    }

    /**
     * Save a transaction.
     *
     * @param Transaction $transaction Transaction
     */
    public function save(Transaction $transaction): void
    {
        $this->transactionRepository->save($transaction);
    }

    /**
     * Delete a transaction.
     *
     * @param Transaction $transaction Transaction
     */
    public function delete(Transaction $transaction): void
    {
        $this->transactionRepository->delete($transaction);
    }
}
