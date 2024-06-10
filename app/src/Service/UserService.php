<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * User Service.
 */
class UserService implements UserServiceInterface
{
    /**
     * User repository.
     */
    private UserRepository $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepository $userRepository User repository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Save user email.
     *
     * @param User $user User entity
     */
    public function saveEmail(User $user): void
    {
        $this->userRepository->saveEmail($user);
    }

    /**
     * Save user password.
     *
     * @param User $user User entity
     */
    public function savePassword(User $user): void
    {
        $this->userRepository->savePassword($user);
    }
}
