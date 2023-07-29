<?php
include '../classes/Api.class.php';

header("Content-type: application/json; charset=utf-8");
$api = new Api("https://jsonplaceholder.typicode.com/");
echo $api->addPost(4, 'Title of the post', 'This post is about something, this is post`s body');