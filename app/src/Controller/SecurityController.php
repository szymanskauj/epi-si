<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * SecurityController manages user authentication.
 */
class SecurityController extends AbstractController
{
    /**
     * Handles the login process.
     *
     * @param AuthenticationUtils $authenticationUtils utilizes helper functions for authentication
     *
     * @return Response the HTTP response with the login page rendered
     */
    #[Route(
        path: '/login',
        name: 'app_login'
    )]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('wallet_index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * Handles the logout process.
     *
     * @throws \LogicException this method can be blank as it is intercepted by the logout key on the firewall
     */
    #[Route(
        path: '/logout',
        name: 'app_logout'
    )]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
