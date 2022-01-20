<?php

namespace App\Entity;

use App\Repository\OrgRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: OrgRepository::class)]
#[ApiResource]

class Org
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $name;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $link;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Repo::class)]
    private $repos;

    #[ORM\Column(type: 'string', length: 100)]
    private $provider;

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

    public function setName(?string $name): self
    {
        $this->name = $name;

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
    public function __toString(){ return $this->name; }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }
}
