<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Service;

use App\Entity\Wallet;
use App\Repository\TransactionRepository;
use App\Repository\WalletRepository;

/**
 * Wallet Service.
 */
class WalletService implements WalletServiceInterface
{
    /**
     * Wallet repository.
     */
    private WalletRepository $walletRepository;

    /**
     * Transaction repository.
     */
    private TransactionRepository $transactionRepository;

    /**
     * Constructor.
     *
     * @param WalletRepository      $walletRepository      Wallet repository
     * @param TransactionRepository $transactionRepository Transaction repository
     */
    public function __construct(WalletRepository $walletRepository, TransactionRepository $transactionRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Get all wallets.
     *
     * @return Wallet[] An array of Wallet entities
     */
    public function getWallets(): array
    {
        return $this->walletRepository->getWallets();
    }

    /**
     * Save a wallet.
     *
     * @param Wallet $wallet Wallet entity
     */
    public function save(Wallet $wallet): void
    {
        $this->walletRepository->save($wallet);
    }

    /**
     * Delete a wallet.
     *
     * @param Wallet $wallet Wallet entity
     */
    public function delete(Wallet $wallet): void
    {
        $transactions = $this->transactionRepository->findByWallet($wallet);
        foreach ($transactions as $transaction) {
            $this->transactionRepository->delete($transaction);
        }
        $this->walletRepository->delete($wallet);
    }
}
