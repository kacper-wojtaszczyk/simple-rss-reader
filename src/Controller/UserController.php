<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    public function __construct(Environment $twig, Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
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
    public function register(): Response
    {
        $content = $this->twig->render('user/register.html.twig');

        return Response::create($content, Response::HTTP_OK);
    }

    /**
     * @Route("/_ajax/validate-email", name="ajax_validate_email")
     */
    public function validateEmail(): Response
    {
        //TODO implement email validation
        return JsonResponse::create(true, Response::HTTP_OK);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
    }
}
