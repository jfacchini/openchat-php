<?php

namespace App\Domain\Users;

interface UserRepository
{
    /**
     * Add a new user instance in its repository.
     *
     * @param User $user
     */
    public function add(User $user): void;

    /**
     * Informs whether a Username is already taken by an existing user.
     *
     * @param string $username
     *
     * @return bool
     */
    public function isUsernameTaken(string $username): bool;

    /**
     * Retrieves a User from its identifier.
     *
     * @param string $id
     *
     * @return User
     */
    public function get(string $id): User;

    /**
     * Retieves all existing Users within the repository.
     *
     * @return User[]
     */
    public function all(): array;
}
