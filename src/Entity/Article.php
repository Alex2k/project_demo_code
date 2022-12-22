<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Table(name="article")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    use DateTimeTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $preview;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $contentHtml;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $contentMarkdown;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $isPublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $publishedAt;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="posts")
     *
     * @var Collection|Tag[]
     */
    private Collection $tags;

    public function __construct(
        ?string $image = null,
        ?string $title = null,
        ?string $preview = null,
        ?string $contentHtml = null,
        ?string $contentMarkdown = null,
        ?bool $isPublished = null,
        ?DateTimeInterface $publishedAt = null
    ) {
        $this
            ->setImage($image)
            ->setTitle($title)
            ->setPreview($preview)
            ->setContentHtml($contentHtml)
            ->setContentMarkdown($contentMarkdown)
            ->setIsPublished($isPublished)
            ->setPublishedAt($publishedAt)
        ;

        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(?string $preview): self
    {
        $this->preview = $preview;

        return $this;
    }

    public function getContentHtml(): ?string
    {
        return $this->contentHtml;
    }

    public function setContentHtml(?string $contentHtml): self
    {
        $this->contentHtml = $contentHtml;

        return $this;
    }

    public function getContentMarkdown(): ?string
    {
        return $this->contentMarkdown;
    }

    public function setContentMarkdown(?string $contentMarkdown): self
    {
        $this->contentMarkdown = $contentMarkdown;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
