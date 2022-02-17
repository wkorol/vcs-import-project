<?php

namespace App\Entity;

use App\Repository\GithubRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: GithubRepository::class)]
class Github extends Repo implements JsonSerializable
{

    #[ORM\Column(type: 'float')]
    private $points;
    #[ORM\Column(type: 'integer')]
    private $stars;

    public function getPoints(): ?float
    {
        return $this->points;
    }

    public function setPoints(): float
    {
        return $this->points = $this->getCommits() + $this->getPulls() * 1.2 + $this->getStars() * 2;;
    }
    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }
    

    public function jsonSerialize() : mixed
    {
        
        
            
            return array(
                'repo' => parent::jsonSerialize(), 'provider' => 'github'
                
            );
            
            
            
            
    }
    
    
}
