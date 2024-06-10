<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\Wallet;
use App\Form\Type\TransactionType;
use App\Service\TransactionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Controller that manages transactions within a wallet.
 *
 * @Route("/wallet/{id}/transactions", requirements={"id"="[1-9]\d*"})
 */
#[Route(
    '/wallet/{id}/transactions',
    requirements: ['id' => '[1-9]\d*']
)]
class TransactionController extends AbstractController
{
    /**
     * Transaction service.
     */
    private TransactionServiceInterface $transactionService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * TransactionController constructor.
     *
     * @param TransactionServiceInterface $transactionService The transaction service.
     * @param TranslatorInterface         $translator         The translator.
     */
    public function __construct(TransactionServiceInterface $transactionService, TranslatorInterface $translator)
    {
        $this->transactionService = $transactionService;
        $this->translator = $translator;
    }

    /**
     * Lists all transactions for a given wallet.
     *
     * @param Request $request The HTTP request.
     * @param Wallet  $wallet  The wallet entity.
     *
     * @return Response The HTTP response with the transactions list.
     */
    #[Route(
        name: 'wallet_transactions',
        methods: 'GET'
    )]
    public function index(Request $request, Wallet $wallet): Response
    {
        $days = $request->query->getInt('days');
        $categoryId = $request->query->getInt('filters_category_id');
        $transactions = $this->transactionService->findByWallet($wallet, $categoryId, $days);

        return $this->render(
            'transaction/index.html.twig',
            [
                'transactions' => $transactions,
                'wallet' => $wallet,
            ]
        );
    }

    /**
     * Creates a new transaction for a given wallet.
     *
     * @param Request $request The HTTP request.
     * @param Wallet  $wallet  The wallet entity.
     *
     * @return Response The HTTP response.
     */
    #[Route(
        '/create',
        name: 'transaction_create',
        methods: 'GET|POST'
    )]
    public function create(Request $request, Wallet $wallet): Response
    {
        $transaction = new Transaction();
        $transaction->setCreatedAt(new \DateTimeImmutable());
        $transaction->setUpdatedAt(new \DateTime());

        $form = $this->createForm(
            TransactionType::class,
            $transaction
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleTransaction($transaction, $wallet);

            return $this->redirectToRoute(
                'wallet_transactions',
                [
                    'id' => $wallet->getId()
                ]
            );
        }

        return $this->render(
            'transaction/create.html.twig',
            [
                'form' => $form->createView(),
                'wallet' => $wallet
            ]
        );
    }

    /**
     * Displays a specific transaction.
     *
     * @param Wallet $wallet The wallet entity.
     * @param int $transaction_id The transaction ID.
     *
     * @return Response The HTTP response with the transaction details.
     */
    #[Route(
        '/{transaction_id}',
        name: 'transaction_show',
        requirements: ['transaction_id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Wallet $wallet, int $transaction_id): Response
    {
        $transaction = $this->transactionService->findById($transaction_id);
        return $this->render(
            'transaction/show.html.twig',
            [
                'transaction' => $transaction,
                'wallet' => $wallet
            ]
        );
    }

    /**
     * Edits an existing transaction.
     *
     * @param Request $request The HTTP request.
     * @param Wallet $wallet The wallet entity.
     * @param int $transaction_id The transaction ID.
     *
     * @return Response The HTTP response.
     */
    #[Route(
        '/{transaction_id}/edit',
        name: 'transaction_edit',
        requirements: ['transaction_id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Wallet $wallet, int $transaction_id): Response
    {
        $transaction = $this->transactionService->findById($transaction_id);
        $form = $this->createForm(
            TransactionType::class,
            $transaction,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl(
                    'transaction_edit', [
                        'id' => $wallet->getId(),
                        'transaction_id' => $transaction->getId(),
                    ]
                ),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleTransaction($transaction, $wallet);

            return $this->redirectToRoute(
                'wallet_transactions',
                [
                    'id' => $wallet->getId()
                ]
            );
        }
        return $this->render(
            'transaction/edit.html.twig',
            [
                'form' => $form->createView(),
                'transaction' => $transaction,
                'wallet' => $wallet
            ]
        );
    }

    /**
     * Handles the transaction, updating the wallet and saving the transaction.
     *
     * @param Transaction $transaction The transaction entity.
     * @param Wallet $wallet The wallet entity.
     */
    private function handleTransaction(Transaction $transaction, Wallet $wallet): void
    {
        if ($transaction->getAmount() < 0 && abs($transaction->getAmount()) > $wallet->getBalance()) {
            $this->addFlash(
                'danger',
                $this->translator->trans('message.balance_error')
            );
        } else {
            $wallet->setUpdatedAt(new \DateTime());
            $transaction->setUpdatedAt(new \DateTime());
            $transaction->setWallet($wallet);
            $wallet->setBalance($wallet->getBalance() + $transaction->getAmount());
            $this->transactionService->save($transaction);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );
        }
    }
}
