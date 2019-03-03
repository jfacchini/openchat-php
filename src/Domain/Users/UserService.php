<?php

namespace App\Domain\Users;

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
        // UserRepository should be an interface in order to inject a concrete implementation
        // that can be implemented InMemory, File, Database, etc...
        $this->userRepository = $userRepository;
        // Should IdGenerator be the same? We could potentially wrap a library that generates UUID.
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
}
