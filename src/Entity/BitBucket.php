<?php

namespace App\Entity;

use App\Repository\BitBucketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BitBucketRepository::class)]
class BitBucket extends Repo
{

    #[ORM\Column(type: 'float')]
    private $points;

    public function getPoints(): ?float
    {
        return $this->points;
    }

    public function setPoints(): float
    {
        

        return $this->points = $this->getCommits() + $this->getPulls() * 1.4 * 4;
    }
    public function jsonSerialize() : mixed
    {        
            return array(
                'repo' => parent::jsonSerialize(), 'provider' => 'bitbucket'
            );
        
            
    }

    
}
