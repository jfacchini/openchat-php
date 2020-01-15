<?php

namespace App\Domain\Users;

use Exception;

class UserService
{
    private UserIdGenerator $idGenerator;

    private UserRepository $userRepository;

    public function __construct(UserIdGenerator $idGenerator, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
