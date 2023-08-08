<?php

spl_autoload_register(function ($class) {
	require_once(__DIR__ . '/classes/' . $class . '.class.php');
});

$request = new Request('https://jsonplaceholder.typicode.com/');
$json = $request->execute($request::GET, 'comments');
$decode = json_decode($json, true);

$postIdArray =  array_column($decode, 'postId');

function countPosts($postIdArray): int
{
    return count(array_unique($postIdArray));
}
function maxCommentPostId($postIdArray){
    $arrayCountValues = array_count_values($postIdArray);
    arsort($arrayCountValues);
    return array_key_first($arrayCountValues);
}
function countMaxComment($postIdArray){
    $arrayCountValues = array_count_values($postIdArray);
    arsort($arrayCountValues);
    return array_shift($arrayCountValues);
}
$response = new Request('https://webhook.site/6001d3b2-e104-4abe-a23f-cc7febb88979');

$response->execute($response::POST, '', [
    'postsCount'=>countPosts($postIdArray),
    'maxCommentPostId'=>maxCommentPostId($postIdArray),
    'maxCommentCount' => countMaxComment($postIdArray),
]);