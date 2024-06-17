<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Service;

use App\Entity\Category;

/**
 * Category service interface.
 */
interface CategoryServiceInterface
{
    /**
     * Get all categories.
     *
     * @return array categories
     */
    public function getCategories(): array;

    /**
     * Save a category.
     *
     * @param Category $category Category
     */
    public function save(Category $category): void;

    /**
     * Delete a category.
     *
     * @param Category $category Category
     */
    public function delete(Category $category): void;

    /**
     * Check if a category can be deleted.
     *
     * @param Category $category Category
     *
     * @return bool Result
     */
    public function canDelete(Category $category): bool;

    /**
     * Find category by id.
     *
     * @param int $id id
     *
     * @return Category|null Category
     */
    public function findById(int $id): ?Category;
}
