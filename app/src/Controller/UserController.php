<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Controller;

use App\Form\Type\UserEmailType;
use App\Form\Type\UserPasswordType;
use App\Service\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * UserController handles user-related actions.
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/user")
 */
#[IsGranted('ROLE_ADMIN')]
#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param UserServiceInterface $userService User service
     * @param TranslatorInterface  $translator  the translator
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    /**
     * Render the user edit page.
     *
     * @return Response the HTTP response
     */
    #[Route(
        '/edit',
        name: 'user_edit'
    )]
    public function edit(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * Change user's email.
     *
     * @param Request                $request       the HTTP request
     * @param EntityManagerInterface $entityManager the entity manager
     *
     * @return Response the HTTP response
     */
    #[Route(
        '/change-email',
        name: 'user_change_email',
        methods: 'GET|PUT'
    )]
    public function changeEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('The user must be an instance of \App\Entity\User');
        }
        $form = $this->createForm(
            UserEmailType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('user_change_email'),
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->saveEmail($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.changed_email')
            );

            return $this->redirectToRoute('user_edit');
        }

        return $this->render(
            'user/email.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * Change user's password.
     *
     * @param Request                $request       the HTTP request
     * @param EntityManagerInterface $entityManager the entity manager
     *
     * @return Response the HTTP response
     */
    #[Route(
        '/change-password',
        name: 'user_change_password',
        methods: 'GET|PUT'
    )]
    public function changePassword(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('The user must be an instance of \App\Entity\User');
        }
        $form = $this->createForm(
            UserPasswordType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('user_change_password'),
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->savePassword($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.changed_password')
            );

            return $this->redirectToRoute('user_edit');
        }

        return $this->render(
            'user/password.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }
}
