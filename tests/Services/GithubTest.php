<?php

namespace App\Tests\Services;

use App\Entity\Org;
use App\Repository\OrgRepository;
use App\Services\GithubService;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GithubTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByName()
    {
        $org = $this->entityManager
            ->getRepository(Org::class)
            ->findOneBy(['name' => 'wkorol'])
        ;

        $this->assertSame('wkorol', $org->getName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
