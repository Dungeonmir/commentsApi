<?php
include '../classes/ErrorHandler.class.php';
class Api
{
	private $apiURL;
	function __construct($URL)
	{
		$this->apiURL = $URL;
	}
	private function curlRequest($method, $endpoint, $data = null)
	{

		$curl = curl_init($this->apiURL . $endpoint);
		switch ($method) {
			case 'POST':
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $data
				]);
				break;

			default:

				break;
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;

	}
	private function getData($endpoint)
	{
		$response = $this->curlRequest("GET", $endpoint);
		if (!$response) {
			return ErrorHandler::JSONResponse(404, 'Resource not found');
		}
		return $response;

	}
	private function postData($endpoint, $data)
	{
		$response = $this->curlRequest("POST", $endpoint, $data);
		return $response;
	}
	public function getUsers()
	{
		return $this->getData('users/');
	}
	public function getUser(int $id)
	{
		return $this->getData('users/' . $id);
	}
	public function getPosts($userId = null)
	{
		if (is_null($userId)) {
			// Получение всех постов
			return $this->getData('posts/');
		}
		// Получение постов пользователя
		return $this->getData('users/' . $userId . '/posts/');
	}
	public function getPost($id)
	{
		return $this->getData('posts/' . $id);
	}

	public function getTodos($userId = null)
	{
		$response = null;
		if (is_null($userId)) {
			// Получение всех заданий
			$response = $this->getData('todos/');
		} else {
			// Получение заданий определенного пользователя
			$response = $this->getData('users/' . $userId . '/todos');
		}
		return $response;
	}
	public function getTodo($id)
	{
		return $this->getData('todos/' . $id);
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

		return $this->postData(
			'posts/',
			json_encode($data)
		);
	}

}