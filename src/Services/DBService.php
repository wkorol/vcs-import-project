<?php 

namespace App\Services;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function PHPUnit\Framework\isEmpty;

abstract class DBService
{
  
    
    
    public function fetchData($url, $headers): array {
        
        $response = $this->client->request('GET', $url, ['headers' => $headers]);
        if($response->getStatusCode()!=200)
            return [];
        $rep = $response->toArray();
        return $rep;
    }


}




?>