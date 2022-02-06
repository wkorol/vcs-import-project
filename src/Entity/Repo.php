<?php

namespace App\Entity;

use App\Repository\RepoRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: RepoRepository::class)]

class Repo implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $name;

    #[ORM\Column(type: 'date', nullable: true)]
    private $create_date;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $link;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stars;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pulls;

    #[ORM\Column(type: 'float', nullable: true)]
    private $points;

    #[ORM\ManyToOne(targetEntity: Org::class, inversedBy: 'repos')]
    #[ORM\JoinColumn(nullable: false)]
    private $org;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $commits;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(?\DateTimeInterface $create_date): self
    {
        $this->create_date = $create_date;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(?int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }

    public function getPulls(): ?int
    {
        return $this->pulls;
    }

    public function setPulls(?int $pulls): self
    {
        $this->pulls = $pulls;

        return $this;
    }

    public function getPoints(): ?float
    {
        return $this->points;
    }

    public function setPoints(?float $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getOrg(): ?Org
    {
        return $this->org;
    }

    public function setOrg(?Org $org): self
    {
        $this->org = $org;

        return $this;
    }

    public function getCommits(): ?int
    {
        return $this->commits;
    }

    public function setCommits(?int $commits): self
    {
        $this->commits = $commits;

        return $this;
    }
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'org' => $this->getOrg(),
            'pulls' => $this->pulls,
            'stars' => $this->stars,
            'commits' => $this->commits,
            'trust_points' => $this->points
            
        );
    }

}
