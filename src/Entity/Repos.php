<?php

namespace App\Entity;

use App\Repository\ReposRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReposRepository::class)]
class Repos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'datetime', length: 100)]
    private $create_date;

    #[ORM\Column(type: 'string', length: 100)]
    private $link;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stars;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pulls_size;

    #[ORM\OneToMany(mappedBy: 'repos', targetEntity: Organisation::class)]
    private $organisations;


    #[ORM\Column(type: 'integer', nullable: true)]
    private $commits_size;

    #[ORM\Column(type: 'float', nullable: true)]
    private $points;

    public function __construct()
    {
        $this->organisations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreateDate(): ?string
    {
        return $this->create_date;
    }

    public function setCreateDate(string $create_date): self
    {
        $this->create_date = $create_date;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
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

    public function getPullsSize(): ?int
    {
        return $this->pulls_size;
    }

    public function setPullsSize(?int $pulls_size): self
    {
        $this->pulls_size = $pulls_size;

        return $this;
    }

    /**
     * @return Collection|Organisation[]
     */
    public function getOrganisations(): Collection
    {
        return $this->organisations;
    }

    public function addOrganisation(Organisation $organisation): self
    {
        if (!$this->organisations->contains($organisation)) {
            $this->organisations[] = $organisation;
            $organisation->setRepos($this);
        }

        return $this;
    }

    public function removeOrganisation(Organisation $organisation): self
    {
        if ($this->organisations->removeElement($organisation)) {
            // set the owning side to null (unless already changed)
            if ($organisation->getRepos() === $this) {
                $organisation->setRepos(null);
            }
        }

        return $this;
    }

    public function getPoints(): ?Points
    {
        return $this->points;
    }

    public function setPoints(Points $points): self
    {
        // set the owning side of the relation if necessary
        if ($points->getRepo() !== $this) {
            $points->setRepo($this);
        }

        $this->points = $points;

        return $this;
    }

    public function getCommitsSize(): ?int
    {
        return $this->commits_size;
    }

    public function setCommitsSize(?int $commits_size): self
    {
        $this->commits_size = $commits_size;

        return $this;
    }
}
