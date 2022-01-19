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


        return $rep;
    }
}
