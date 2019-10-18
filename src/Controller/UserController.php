<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Controller;

use Doctrine\ORM\EntityManagerInterface;
use KacperWojtaszczyk\SimpleRssReader\Repository\User\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class UserController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(Environment $twig, Security $security, UrlGeneratorInterface $urlGenerator,
                                UserRepository $userRepository, FormFactoryInterface $formFactory,
                                EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
        $this->formFactory = $formFactory;
        $this->em = $em;
    }

    /**
     * @Route("/_ajax/validate-email", name="ajax_validate_email", methods={"POST"})
     */
    public function validateEmail(Request $request): Response
    {
        if(null !== $this->userRepository->findOneBy(['email' => $request->request->get('email')]))
        {
            return JsonResponse::create(true, Response::HTTP_CONFLICT);
        }
        return JsonResponse::create(true, Response::HTTP_OK);
    }

//    /**
//     * @Route("/logout", name="logout")
//     */
//    public function logout(): void
//    {
//    }
}
