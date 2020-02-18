<?php

namespace App\Infrastructure\Api;

use App\Domain\Users\UserCredentials;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Normalizers\UserNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginApi
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(methods={"POST"}, name="user_login", path="/api/login")
     */
    public function login(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        $user = $this->userRepository->userFor(new UserCredentials(
            $content['username'],
            $content['password'],
        ));

        return new JsonResponse(UserNormalizer::normalize($user->get()));
    }
}
