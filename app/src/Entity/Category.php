<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 */

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category entity class.
 *
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 *
 * @ORM\Table(name="categories")
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
class Category
{
    /**
     * Primary key.
     *
     * @var int|null Primary key
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Created At.
     *
     * @var \DateTimeImmutable|null Created At
     */
    #[ORM\Column]
    #[Assert\Type(\DateTimeImmutable::class)]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Updated At.
     *
     * @var \DateTimeInterface|null Updated At
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * Title.
     *
     * @var string|null Title
     */
    #[ORM\Column(length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $title = null;

    /**
     * Getter for id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for createdAt.
     *
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for createdAt.
     *
     * @param \DateTimeImmutable $createdAt Created At
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for updatedAt.
     *
     * @return \DateTimeInterface|null Updated At
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updatedAt.
     *
     * @param \DateTimeInterface $updatedAt Updated At
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
