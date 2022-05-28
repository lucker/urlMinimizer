<?php

namespace App\Entity;

use App\Repository\UrlMinimizerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\ByteString;

#[ORM\Entity(repositoryClass: UrlMinimizerRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UrlMinimizer
{
    public const IS_ACTIVE = true;
    public const MINIMIZED_URL_LENGTH = 10;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\Column(type: 'string', length: 255)]
    private $minimizedUrl;

    #[ORM\Column(type: 'integer')]
    private $lifeTime;

    #[ORM\Column(type: 'integer')]
    private $clickCount;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\Column(type: 'datetime')]
    private $created;

    #[ORM\Column(type: 'datetime')]
    private $updated;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lifeTimeEnded;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getMinimizedUrl(): ?string
    {
        return $this->minimizedUrl;
    }

    public function setMinimizedUrl(string $minimizedUrl): self
    {
        $this->minimizedUrl = $minimizedUrl;

        return $this;
    }

    public function getLifeTime(): ?int
    {
        return $this->lifeTime;
    }

    public function setLifeTime(int $lifeTime): self
    {
        $this->lifeTime = $lifeTime;

        return $this;
    }

    public function getClickCount(): ?int
    {
        return $this->clickCount;
    }

    public function setClickCount(int $clickCount): self
    {
        $this->clickCount = $clickCount;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getLifeTimeEnded(): ?\DateTimeInterface
    {
        return $this->lifeTimeEnded;
    }

    public function setLifeTimeEnded(?\DateTimeInterface $lifeTimeEnded): self
    {
        $this->lifeTimeEnded = $lifeTimeEnded;

        return $this;
    }
    #[ORM\PrePersist]
    public function setData(): void
    {
        $this->minimizedUrl =  ByteString::fromRandom(self::MINIMIZED_URL_LENGTH)
            ->toString();
        $this->clickCount = 0;
        $this->active = self::IS_ACTIVE;
        $this->updated =  new \DateTime('now');
        $this->created =  new \DateTime('now');
    }

}
