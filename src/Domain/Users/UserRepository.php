<?php

namespace App\Domain\Users;

use ocramius\util\Optional;

interface UserRepository
{
    /**
     * Add a new user instance in its repository.
     */
    public function add(User $user): void;

    /**
     * Informs whether a Username is already taken by an existing user.
     */
    public function isUsernameTaken(string $username): bool;

    /**
     * Retrieves a User from its identifier.
     */
    public function get(UserId $id): User;

    /**
     * Find a user from given credentials.
     *
     * @return Optional<User> Maybe containing a User
     */
    public function userFor(UserCredentials $credentials): Optional;

    /**
     * Retrieves all existing Users within the repository.
     *
     * @return User[]
     */
    public function all(): array;
}
