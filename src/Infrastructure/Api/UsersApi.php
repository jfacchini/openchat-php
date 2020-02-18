<?php

namespace App\Infrastructure\Api;

use App\Domain\Users\RegistrationData;
use App\Domain\Users\User;
use App\Domain\Users\UsernameAlreadyInUseException;
use App\Domain\Users\UserService;
use App\Infrastructure\Normalizers\UserNormalizer;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersApi
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route(methods={"POST"}, name="register_user", path="/api/users")
     */
    public function createUser(Request $request): Response
    {
        $registrationData = $this->registrationDataFrom($request);

        try {
            // In a CQRS manner I would rename `createUser` to `register` and create a new `UserId`
            // but should UserId be part of the RegistrationData? or should it be a second argument?
            $user = $this->userService->createUser($registrationData);

            return new JsonResponse(
                // Normalizers will be useful to be used with Symfony Serializer component.
                UserNormalizer::normalize($user),
                Response::HTTP_CREATED,
            );
        } catch (UsernameAlreadyInUseException $e) {
            return new JsonResponse(
                [
                    'message' => 'Username already in use.',
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }

    private function registrationDataFrom(Request $request): RegistrationData
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

    /**
     * @Route(methods={"GET"}, name="all_users", path="/api/users")
     *
     * @throws Exception
     */
    public function allUsers(): Response
    {
        $users = $this->userService->allUsers();

        return new JsonResponse(array_map(function (User $user) {
            return UserNormalizer::normalize($user);
        }, $users));
    }
}
