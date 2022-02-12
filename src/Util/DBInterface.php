<?php
namespace App\Util;

interface DBInterface {
    public function fetchData($url, $headers): array;
    public function importToDb($orgName): bool;
}


?>