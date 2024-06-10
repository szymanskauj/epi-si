<?php

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\Type\WalletType;
use App\Service\WalletServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Controller for managing wallets.
 *
 * @IsGranted("ROLE_USER")
 *
 * @Route("/wallet")
 */
#[IsGranted('ROLE_USER')]
#[Route('/wallet')]
class WalletController extends AbstractController
{
    /**
     * Wallet service.
     */
    private WalletServiceInterface $walletService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * WalletController constructor.
     *
     * @param WalletServiceInterface $walletService The wallet service.
     * @param TranslatorInterface    $translator    The translator.
     */
    public function __construct(WalletServiceInterface $walletService, TranslatorInterface $translator)
    {
        $this->walletService = $walletService;
        $this->translator = $translator;
    }

    /**
     * Display a list of wallets.
     *
     * @return Response The response.
     */
    #[Route(
        name: 'wallet_index',
        methods: 'GET'
    )]
    public function index(): Response
    {
        $wallets = $this->walletService->getWallets();

        return $this->render(
            'wallet/index.html.twig',
            [
                'wallets' => $wallets
            ]
        );
    }

    /**
     * Create a new wallet.
     *
     * @param Request $request The HTTP request.
     * @return Response The response.
     */
    #[Route(
        '/create',
        name: 'wallet_create',
        methods: 'GET|POST'
    )]
    public function create(Request $request): Response
    {
        $wallet = new Wallet();
        $wallet->setCreatedAt(new \DateTimeImmutable());
        $wallet->setUpdatedAt(new \DateTime());

        $form = $this->createForm(
            WalletType::class,
            $wallet
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->walletService->save($wallet);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Show details of a specific wallet.
     *
     * @param Wallet $wallet The wallet entity.
     * @return Response The response.
     */
    #[Route(
        '/{id}',
        name: 'wallet_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET')
    ]
    public function show(Wallet $wallet): Response
    {
        return $this->render(
            'wallet/show.html.twig',
            [
                'wallet' => $wallet
            ]
        );
    }

    /**
     * Edit a wallet.
     *
     * @param Request $request The HTTP request.
     * @param Wallet $wallet The wallet entity.
     * @return Response The response.
     */
    #[Route(
        '/{id}/edit',
        name: 'wallet_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Wallet $wallet): Response
    {
        $form = $this->createForm(
            WalletType::class,
            $wallet,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl(
                    'wallet_edit',
                    [
                        'id' => $wallet->getId()
                    ]
                ),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wallet->setUpdatedAt(new \DateTime());
            $this->walletService->save($wallet);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/edit.html.twig',
            [
                'form' => $form->createView(),
                'wallet' => $wallet,
            ]
        );
    }

    /**
     * Delete a wallet.
     *
     * @param Request $request The HTTP request.
     * @param Wallet $wallet The wallet entity.
     * @return Response The response.
     */
    #[Route(
        '/{id}/delete',
        name: 'wallet_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Wallet $wallet): Response
    {
        $form = $this->createForm(
            FormType::class,
            $wallet,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl(
                    'wallet_delete',
                    [
                        'id' => $wallet->getId()
                    ]
                ),
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->walletService->delete($wallet);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/delete.html.twig',
            [
                'form' => $form->createView(),
                'wallet' => $wallet,
            ]
        );
    }
}
