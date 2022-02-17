<?php

namespace App\Entity;

use App\Repository\RepoRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: RepoRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "provider", type: "string")]
#[ORM\DiscriminatorMap(['github' => Github::class, 'bitbucket' => BitBucket::class])]
abstract class Repo implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $create_date;

    #[ORM\Column(type: 'string', length: 255)]
    private $link;

    

    #[ORM\Column(type: 'integer')]
    private $pulls;

    #[ORM\Column(type: 'integer')]
    private $commits;


    #[ORM\ManyToOne(targetEntity: Org::class, inversedBy: 'repos', cascade: ['persist'])]
    private $org;

   
    

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

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(\DateTimeInterface $create_date): self
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


    public function getPulls(): ?int
    {
        return $this->pulls;
    }

    public function setPulls(int $pulls): self
    {
        $this->pulls = $pulls;

        return $this;
    }

    public function getCommits(): ?int
    {
        return $this->commits;
    }

    public function setCommits(int $commits): self
    {
        $this->commits = $commits;

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

    

    

    public function jsonSerialize() : mixed
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'org' => $this->getOrg(),
            'pulls' => $this->pulls,
            'commits' => $this->commits,
            
            
        );
    }


}
