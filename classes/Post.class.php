<?php
include './classes/Request.class.php';
class Post
{
	private $api;
	public function __construct($url)
	{
		$this->api = new Request($url);
	}


	public function getPosts($userId = null)
	{
		if (is_null($userId)) {
			// Получение всех постов
			return $this->api->GETrequest('posts/');
		}
		// Получение постов пользователя
		return $this->api->GETrequest('users/' . $userId . '/posts/');
	}
	public function getPost($id)
	{
		return $this->api->GETrequest('posts/' . $id);
	}
	public function addPost($userId = null, $title = null, $body = null)
	{
		$data = [];
		if ($userId !== null) {
			$data['userId'] = $userId;
		}

		if ($title !== null) {
			$data['title'] = $title;
		}
		if ($body !== null) {
			$data['body'] = $body;
		}

		return $this->api->POSTrequest(
			'posts/',
			json_encode($data)
		);
	}

	public function changePost($postId, $userId = null, $title = null, $body = null)
	{
		$data = [];
		if ($userId !== null) {
			$data['userId'] = $userId;
		}

		if ($title !== null) {
			$data['title'] = $title;
		}
		if ($body !== null) {
			$data['body'] = $body;
		}
		return $this->api->PATCHrequest('posts/' . $postId, json_encode($data));
	}
	public function deletePost($postId)
	{
		return $this->api->DELETErequest('posts/' . $postId);
	}

}