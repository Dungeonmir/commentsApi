<?php
include './classes/Post.class.php';

echo '
<style>
	.post{
	background-color: lightgray;
	padding: 5px;
	text-align: center;
	max-width: 300px;
	}
	.posts{
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	}
	h1{
		color: #111; font-family: "Helvetica Neue", sans-serif; font-size: 60px; font-weight: bold; letter-spacing: -1px; line-height: 1; text-align: center; 
	}
</style>
<H1>Посты</H1>';
$url = 'https://jsonplaceholder.typicode.com/';
$post = new Post($url);
$json = $post->getPosts();
$posts = json_decode($json);
echo '<div class="posts">';

foreach ($posts as $post) {

	echo '<div class="post">';
	echo '<p>' . htmlspecialchars($post->id) . '</p>';
	echo '<h3>' . htmlspecialchars($post->title) . '</h3>';
	echo '<p>' . htmlspecialchars($post->body) . '</p>';
	echo '</div>';
}

echo '</div>';