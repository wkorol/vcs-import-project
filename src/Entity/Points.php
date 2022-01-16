<?php

namespace App\Entity;

use App\Repository\PointsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointsRepository::class)]
class Points
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $points;

    #[ORM\OneToOne(inversedBy: 'points', targetEntity: Repos::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $repo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getRepo(): ?Repos
    {
        return $this->repo;
    }

    public function setRepo(Repos $repo): self
    {
        $this->repo = $repo;

        return $this;
    }
}
