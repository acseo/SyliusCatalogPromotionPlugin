<?php

/*
 * This file is part of catalog promotion plugin for Sylius.
 *
 * (c) Ahmed Kooli
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SnakeTn\CatalogPromotion\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Onatera\CoreBundle\Entity\DIYIngredient;
use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Channel\Model\ChannelInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Promotion implements ResourceInterface, CodeAwareInterface
{
    use TimestampableTrait;

    /** @var int|null */
    private $id;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @var string|null
     *
     * @Assert\NotBlank()
     */
    private $name;

    /** @var string|null */
    private $description;

    /** @var int */
    private $priority = 0;

    /** @var bool|null */
    private $exclusive;

    /**
     * @var ?\DateTimeInterface
     *
     * @Assert\NotBlank()
     */
    private $startsAt;

    /**
     * @var ?\DateTimeInterface
     *
     * @Assert\NotBlank()
     */
    private $endsAt;

    /** @var Collection|ChannelPricingInterface[] */
    private $channels;

    /** @var Collection|PromotionAction[] */
    private $actions;

    /** @var Collection|PromotionRule[] */
    private $rules;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->channels = new ArrayCollection();
        $this->rules = new ArrayCollection();
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): void
    {
        $this->priority = $priority;
    }

    public function isExclusive(): ?bool
    {
        return $this->exclusive;
    }

    public function setExclusive(?bool $exclusive): void
    {
        $this->exclusive = $exclusive;
    }

    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(?\DateTimeInterface $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->endsAt;
    }

    public function setEndsAt(?\DateTimeInterface $endsAt): void
    {
        $this->endsAt = $endsAt;
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function hasChannel(ChannelInterface $channel)
    {
        return $this->channels->contains($channel);
    }

    public function addChannel(ChannelInterface $channel): self
    {
        if (!$this->hasChannel($channel)) {
            $this->channels[] = $channel;
        }

        return $this;
    }

    public function removeChannel(ChannelInterface $channel): self
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }

        return $this;
    }

    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(PromotionAction $action): void
    {
        $this->actions->add($action);
        $action->setPromotion($this);
    }

    public function removeAction(PromotionAction $action): void
    {
        $action->setPromotion(null);
        $this->actions->removeElement(actions);
    }

    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(PromotionRule $rule): void
    {
        $this->rules->add($rule);
        $rule->setPromotion($this);
    }

    public function removeRule(PromotionRule $rule): void
    {
        $rule->setPromotion(null);
        $this->rules->removeElement($rule);
    }
}
