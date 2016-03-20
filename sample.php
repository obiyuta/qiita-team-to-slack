<?php

require 'QiitaTeamSlack.php';

$payload = json_decode(file_get_contents('php://input'));

try {
    $qiitaTeamSlack = new QiitaTeamSlack($data);
} catch (Exception $e) {
    echo $e->getMessage();
}

$qiitaTeamSlack->send();