<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    private UrlGeneratorInterface $urlGenerator;

    private SessionInterface $session;

    private Security $security;

    public function __construct(UrlGeneratorInterface $urlGeneratorInterface, SessionInterface $session, Security $security)
    {
        $this->urlGenerator = $urlGeneratorInterface;
        $this->session = $session;
        $this->security = $security;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $user = $this->security->getUser();
        $username = $user ? $user->getUsername() : '';

        $this->session->getFlashBag()->add(
            'danger',
             sprintf('Access Denied! For user "%s"', $username)
        );

        return new RedirectResponse($this->urlGenerator->generate('default'));
    }
}
