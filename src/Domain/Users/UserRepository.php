<?php

namespace App\Domain\Users;

use ocramius\util\Optional;

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
     * @param UserId $id
     *
     * @return User
     */
    public function get(UserId $id): User;

    /**
     * Find a user from given credentials.
     *
     * @param UserCredentials $credentials
     *
     * @return Optional Maybe containing a User
     */
    public function userFor(UserCredentials $credentials): Optional;

    /**
     * Retieves all existing Users within the repository.
     *
     * @return User[]
     */
    public function all(): array;
}
