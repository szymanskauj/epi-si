<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Service;

use App\Entity\Transaction;
use App\Entity\Wallet;

/**
 * Transaction service interface.
 */
interface TransactionServiceInterface
{
    /**
     * Find transactions by wallet.
     */
    public function findByWallet(Wallet $wallet, int $categoryId, int $days): array;

    /**
     * Find transaction by ID.
     */
    public function findById(int $id): ?Transaction;

    /**
     * Save a transaction.
     */
    public function save(Transaction $transaction): void;

    /**
     * Delete a transaction.
     */
    public function delete(Transaction $transaction): void;
}
