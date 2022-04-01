<?php

$db = new PDO('mysql:host=localhost;dbname=playhouse', 'playhouse_admin', '123');

function error(string $href, string $message) : void{
    $err = str_replace(' ', '+', $message);
    die(header('location: '.$href.'?error='.$err));
}