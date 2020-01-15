<?php

namespace App\Infrastructure\Api;

use App\Domain\Users\UserCredentials;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Normalizers\UserNormalizer;
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
     *
     * @param Request $request
     *
     * @return Response
     */
    public function login(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        $user = $this->userRepository->userFor(new UserCredentials(
            $content['username'],
            $content['password'],
        ));

        return new Response(json_encode(UserNormalizer::normalize($user->get())), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
}
