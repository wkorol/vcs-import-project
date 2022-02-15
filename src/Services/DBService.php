<?php 

namespace App\Services;

abstract class DBService
{

    
    public function fetchData($url, $headers): array {
        if($headers['Authorization'] == '') {
            $limiter = $this->anonymousApiLimiter->create();
        } else {
            $limiter = $this->authenticatedApiLimiter->create($headers['Authorization']);
        }
        $limiter->reserve()->wait();
        
            $response = $this->client->request('GET', $url, ['headers' => $headers]);
        
        
        if($response->getStatusCode()!=200)
            return [];
        $rep = $response->toArray();
        
        return $rep;
        
        
    }


}




?>