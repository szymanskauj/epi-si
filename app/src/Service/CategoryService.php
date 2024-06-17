<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TransactionRepository;

/**
 * Category Service.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * Category repository.
     */
    private CategoryRepository $categoryRepository;

    /**
     * Transaction repository.
     */
    private TransactionRepository $transactionRepository;

    /**
     * Constructor.
     *
     * @param CategoryRepository    $categoryRepository    Category repository
     * @param TransactionRepository $transactionRepository Transaction repository
     */
    public function __construct(CategoryRepository $categoryRepository, TransactionRepository $transactionRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Get all categories.
     *
     * @return array categories
     */
    public function getCategories(): array
    {
        return $this->categoryRepository->getCategories();
    }

    /**
     * Save a category.
     *
     * @param Category $category Category
     */
    public function save(Category $category): void
    {
        $this->categoryRepository->save($category);
    }

    /**
     * Delete a category.
     *
     * @param Category $category Category
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }

    /**
     * Check if it's possible to delete a category.
     *
     * @param Category $category Category
     *
     * @return bool Result
     */
    public function canDelete(Category $category): bool
    {
        return !$this->transactionRepository->isCategoryUsed($category);
    }

    /**
     * Find a category.
     *
     * @param int $id id
     *
     * @return Category|null Category
     */
    public function findById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }
}
