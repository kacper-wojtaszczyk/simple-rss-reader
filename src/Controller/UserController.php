<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Controller;

use Doctrine\ORM\EntityManagerInterface;
use KacperWojtaszczyk\SimpleRssReader\Form\UserType;
use KacperWojtaszczyk\SimpleRssReader\Model\User\User;
use KacperWojtaszczyk\SimpleRssReader\Repository\User\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
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
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->security->getUser()) {
           return RedirectResponse::create($this->urlGenerator->generate('feed'));
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $content = $this->twig->render('user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

        return Response::create($content, Response::HTTP_OK);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request): Response
    {
        $user = new User();

        $form = $this->getForm($user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $this->em->persist($user);
            $this->em->flush();
            return RedirectResponse::create($this->urlGenerator->generate('feed'));
        }
        $content = $this->twig->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
        return Response::create($content, Response::HTTP_OK);
    }

    private function getForm($data = null)
    {
        return $this->formFactory->create(UserType::class, $data);
    }

    /**
     * @Route("/_ajax/validate-email", name="ajax_validate_email")
     */
    public function validateEmail(Request $request): Response
    {
        if(null !== $this->userRepository->findOneBy(['email' => $request->request->get('email')]))
        {
            return JsonResponse::create(true, Response::HTTP_CONFLICT);
        }
        return JsonResponse::create(true, Response::HTTP_OK);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
    }
}
