<?php

namespace App\Infrastructure\Api;

use App\Domain\Users\RegistrationData;
use App\Domain\Users\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersApi
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route(methods={"POST"}, name="register_user", path="/api/users")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createUser(Request $request): Response
    {
        $registrationData = $this->registrationDataFrom($request);

        $this->userService->createUser($registrationData);

        return new Response();
    }

    private function registrationDataFrom(Request $request)
    {
        $body = json_decode($request->getContent());

        // Missing validation, is '' a valid username?
        // This is ok for a small object, for bigger one maybe a deserializer?
        return new RegistrationData(
            $body->username ?? '',
            $body->password ?? '',
            $body->about ?? '',
        );
    }
}
