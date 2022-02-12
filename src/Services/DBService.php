<?php 

namespace App\Services;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class DBService
{
  
    public function __construct($providers, RateLimiterFactory $apiLimitter)
    {
        $this->providers = $providers;
        $this->apiLimitter = $apiLimitter;
        
    
        
    }
    // public function checkTokenExists($paramName) : Bool {
    //     if($this->params->get($paramName) == '')
    //         return false;
    //     else return true;
    // }
    
    public function fetchData($url, $headers): array {
        
        $response = $this->client->request('GET', $url, ['headers' => $headers]);
        $rep = $response->toArray();
        return $rep;
    }


}




?>