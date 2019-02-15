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
                'id' => 'd9d9d21f-ece4-4f77-a763-904637b30ef6',
                'username' => 'Username',
                'about' => 'About Username',
            ],
            201, [
                'Content-Type' => 'application/json',
            ],
        );
    }
}
