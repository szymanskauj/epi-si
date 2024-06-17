<?php
/**
 * This file is part of the Wallet project.
 *
 * (c) Martyna Szymańska martyna.81.szymanska@student.uj.edu.pl
 *
 */

namespace App\Entity;

use App\Repository\TransactionRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Transaction entity class.
 *
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ORM\Table(name="transactions")
 */
#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: 'transactions')]
class Transaction
{

    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Amount.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    #[Assert\Range(min: -99999, max: 99999)]
    private ?string $amount = null;

    /**
     * Created At.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column]
    #[Assert\Type(DateTimeImmutable::class)]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Updated At.
     *
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type(DateTimeInterface::class)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Wallet::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(Wallet::class)]
    private ?Wallet $wallet = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Type(Category::class)]
    private ?Category $category = null;

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
     * Getter for amount.
     *
     * @return string|null Amount
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * Setter for amount.
     *
     * @param string $amount Amount
     *
     * @return static
     */
    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
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
     * @param DateTimeImmutable $createdAt Created At
     *
     * @return static
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
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
     *
     * @return static
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Getter for wallet.
     *
     * @return Wallet|null Wallet
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * Setter for wallet.
     *
     * @param Wallet|null $wallet Wallet
     *
     * @return static
     */
    public function setWallet(?Wallet $wallet): static
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Getter for category.
     *
     * @return Category|null Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for category.
     *
     * @param Category|null $category Category
     *
     * @return static
     */
    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
