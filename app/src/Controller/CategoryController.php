<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Service\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Controller that manages transactions categories.
 *
 * @Route("/category")
 */
#[IsGranted('ROLE_USER')]
#[Route('/category')]
class CategoryController extends AbstractController
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService The category service.
     * @param TranslatorInterface      $translator      The translator.
     */
    public function __construct(CategoryServiceInterface $categoryService, TranslatorInterface $translator)
    {
        $this->categoryService = $categoryService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @return Response
     */
    #[Route(
        name: 'category_index',
        methods: 'GET'
    )]
    public function index(): Response
    {
        $categories = $this->categoryService->getCategories();

        return $this->render(
            'category/index.html.twig',
            [
                'categories' => $categories
            ]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request The HTTP request
     *
     * @return Response
     */
    #[Route(
        '/create',
        name: 'category_create',
        methods: 'GET|POST'
    )]
    public function create(Request $request): Response
    {
        $category = new Category();
        $category->setCreatedAt(new \DateTimeImmutable());
        $category->setUpdatedAt(new \DateTime());

        $form = $this->createForm(
            CategoryType::class,
            $category
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->save($category);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            'category/create.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Show action.
     *
     * @param Category $category The category entity
     *
     * @return Response
     */
    #[Route(
        '/{id}',
        name: 'category_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET')
    ]
    public function show(Category $category): Response
    {
        return $this->render(
            'category/show.html.twig',
            [
                'category' => $category
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request The HTTP request
     * @param Category $category The category entity
     *
     * @return Response
     */
    #[Route(
        '/{id}/edit',
        name: 'category_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(
            CategoryType::class,
            $category,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('category_edit', ['id' => $category->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setUpdatedAt(new \DateTime());
            $this->categoryService->save($category);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            'category/edit.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  The HTTP request
     * @param Category $category The category entity
     *
     * @return Response
     */
    #[Route(
        '/{id}/delete',
        name: 'category_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Category $category): Response
    {
        if (!$this->categoryService->canDelete($category)) {
            $this->addFlash(
                'danger',
                $this->translator->trans('message.category_contains_transactions')
            );

            return $this->redirectToRoute('category_index');
        }

        $form = $this->createForm(
            FormType::class,
            $category,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl(
                    'category_delete',
                    [
                        'id' => $category->getId()
                    ]
                ),
            ]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->delete($category);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('category_index');
        }

        return $this->render(
            'category/delete.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category,
            ]
        );
    }
}
