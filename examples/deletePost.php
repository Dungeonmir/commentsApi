<?php
include './classes/Api.class.php';

header("Content-type: application/json; charset=utf-8");
$api = new Api("https://jsonplaceholder.typicode.com/");
echo $api->deletePost(3);