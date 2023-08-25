<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $hasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly JWTTokenManagerInterface $JWTTokenManager

    )
    {
    }

    #[Route(
        path: '/registration',
        name: 'registration',
        methods: ['POST']
    )]
    public function __invoke(Request $request): Response
    {

         $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];

        $user = $this->userRepository->findOneBy([
            'email' => $email
        ]);

        if(!is_null($user)){
            return $this->json([
               'message' => 'User already exists!'
            ],Response::HTTP_CONFLICT);
        }

        $user =  new User();
        $user->setEmail($email);
        $user->setPassword($this->hasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'The registration successfully has been done!',
            'token' => $this->JWTTokenManager->create($user)
        ]);
    }
}
