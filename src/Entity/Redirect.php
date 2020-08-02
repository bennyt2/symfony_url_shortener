<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Redirect
 *
 * @ORM\Table(name="redirect", indexes={@ORM\Index(name="slug_idx", columns={"slug"})})
 * @ORM\Entity()
 */
class Redirect
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 5,
     *      max = 9,
     *      allowEmptyString = true
     * )
     *
     * @ORM\Column(name="slug", type="string", length=9, nullable=false)
     */
    protected $slug;

    /**
     * @var string
     *
     * @Assert\Url()
     *
     * @ORM\Column(name="url", type="text", nullable=false)
     */
    protected $url;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * string|null as it can be empty if the form is submitted without a slug
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
