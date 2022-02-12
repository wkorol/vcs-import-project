<?php

namespace App\Entity;

use App\Repository\BitBucketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BitBucketRepository::class)]
class BitBucket extends Repo
{

    #[ORM\Column(type: 'float')]
    private $points;

    public function __construct($name, $create_date, $link, $pulls, $commits, $org) {
        $this->setName($name);
        $this->setCreateDate($create_date);
        $this->setLink($link);
        $this->setPulls($pulls);
        $this->setCommits($commits);
        $this->setOrg($org);
        $this->setPoints();

    }

    public function getPoints(): ?float
    {
        return $this->points;
    }

    public function setPoints(): float
    {
        

        return $this->points = $this->getCommits() + $this->getPulls() * 1.4 * 4;
    }
    public function jsonSerialize()
    {        
            return array(
                ['repo' => parent::jsonSerialize(), 'provider' => 'bitbucket']
                
            );
        
            
    }

    
}
