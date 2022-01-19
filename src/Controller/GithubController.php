<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class GithubController extends AbstractController

{


    public function fetchData($url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'User-Agent: vcs-import-project', 'Authorization: token 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'));
        $rep = json_decode(curl_exec($ch), true);
        curl_close($ch);

//        $response = $this->client->request(
//            'GET',
//            $url
//        );
//
//        $statusCode = $response->getStatusCode();
//         $statusCode = 200;
//        $contentType = $response->getHeaders()['content-type'][0];
//         $contentType = 'application/json';
//        //$organisation_content = $response->getContent();
//        // $content = '{"id":521583, "name":"symfony-docs", ...}'
//        $content = $response->toArray();



        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $rep;
    }
}
