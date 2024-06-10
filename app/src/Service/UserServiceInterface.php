<?php

namespace App\Service;

use App\Entity\User;

/**
 * User service interface.
 */
interface UserServiceInterface
{
    /**
     * Save user email.
     *
     * @param User $user User entity
     */
    public function saveEmail(User $user): void;

    /**
     * Save user password.
     *
     * @param User $user User entity
     */
    public function savePassword(User $user): void;
}
