<?php

namespace App\Infrastructure\Api\Users;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterApi
{
    /**
     * @Route(methods={"POST"}, name="register_user", path="/api/users")
     *
     * @return Response
     */
    public function register(): Response
    {
        return new JsonResponse(
            [
                'username' => 'Username',
                'password' => 'Password',
            ],
            201, [
                'Content-Type' => 'application/json',
            ],
        );
    }
}
