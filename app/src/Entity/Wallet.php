<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Wallet.
 */
#[ORM\Entity(repositoryClass: WalletRepository::class)]
#[ORM\Table(name: 'wallets')]
class Wallet
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
     * Name.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * Created At.
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    /**
     * Updated At.
     *
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $updatedAt = null;

    /**
     * Balance.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $balance = null;

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
     * Getter for name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for name.
     *
     * @param string $name Name
     *
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for createdAt.
     *
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?DateTimeImmutable
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
    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Getter for updatedAt.
     *
     * @return DateTimeInterface|null Updated At
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updatedAt.
     *
     * @param DateTimeInterface $updatedAt Updated At
     *
     * @return static
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Getter for balance.
     *
     * @return string|null Balance
     */
    public function getBalance(): ?string
    {
        return $this->balance;
    }

    /**
     * Setter for balance.
     *
     * @param string $balance Balance
     *
     * @return static
     */
    public function setBalance(string $balance): static
    {
        $this->balance = $balance;

        return $this;
    }
}
