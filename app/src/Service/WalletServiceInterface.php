<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 *
 */

namespace App\Service;

use App\Entity\Wallet;

/**
 * Wallet service interface
 */
interface WalletServiceInterface
{
    /**
     * Get all wallets.
     *
     * @return Wallet[] An array of Wallet entities
     */
    public function getWallets(): array;
    /**
     * Save a wallet.
     *
     * @param Wallet $wallet Wallet entity
     */
    public function save(Wallet $wallet): void;
    /**
     * Delete a wallet.
     *
     * @param Wallet $wallet Wallet entity
     */
    public function delete(Wallet $wallet): void;
}
