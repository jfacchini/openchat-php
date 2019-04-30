<?php

namespace App\Domain\Users;

use Exception;

class UserService
{
    /**
     * @var IdGenerator
     */
    private $idGenerator;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(IdGenerator $idGenerator, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        // Should IdGenerator an interface as well? We could potentially wrap a library that generates UUID.
        $this->idGenerator = $idGenerator;
    }

    public function createUser(RegistrationData $registrationData): User
    {
        if ($this->userRepository->isUsernameTaken($registrationData->username())) {
            throw new UsernameAlreadyInUseException();
        }

        $user = new User(
            $this->idGenerator->next(),
            $registrationData->username(),
            $registrationData->password(),
            $registrationData->about(),
        );

        $this->userRepository->add($user);

        return $user;
    }

    /**
     * @return User[]
     *
     * @throws Exception
     */
    public function allUsers(): array
    {
        return $this->userRepository->all();
    }
}
