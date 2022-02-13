<?php

namespace App\Entity;

use App\Repository\OrgRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: OrgRepository::class)]
class Org implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Repo::class, cascade: ['persist'])]
    private $repos;

    public function __construct()
    {
        $this->repos = new ArrayCollection();
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

    /**
     * @return Collection|Repo[]
     */
    public function getRepos(): Collection
    {
        return $this->repos;
    }

    public function addRepo(Repo $repo): self
    {
        if (!$this->repos->contains($repo)) {
            $this->repos[] = $repo;
            $repo->setOrg($this);
        }

        return $this;
    }

    public function removeRepo(Repo $repo): self
    {
        if ($this->repos->removeElement($repo)) {
            // set the owning side to null (unless already changed)
            if ($repo->getOrg() === $this) {
                $repo->setOrg(null);
            }
        }

        return $this;
    }
    public function jsonSerialize() : mixed
    {
        return array(
            'id' => $this->id,
            'name' => $this->name
        );
    }
}
