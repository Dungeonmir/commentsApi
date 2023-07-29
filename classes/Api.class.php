<?php
include './classes/ErrorHandler.class.php';
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
			case 'PATCH':
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
					CURLOPT_CUSTOMREQUEST => "PATCH",
					CURLOPT_POSTFIELDS => $data
				]);
				break;
			case 'DELETE':
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
					CURLOPT_CUSTOMREQUEST => "DELETE",
				]);
				break;
			default:

				break;
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);


		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if ($code > 220) {
			$response = ErrorHandler::JSONResponse(500, "The requst wasn't succesful.");
		}


		curl_close($curl);
		return $response;

	}
	private function GETrequest($endpoint)
	{
		$response = $this->curlRequest("GET", $endpoint);
		if (!$response) {
			return ErrorHandler::JSONResponse(404, 'Resource not found');
		}
		return $response;

	}
	private function POSTrequest($endpoint, $data)
	{
		$response = $this->curlRequest("POST", $endpoint, $data);
		return $response;
	}
	private function PATCHrequest($endpoint, $data)
	{
		$response = $this->curlRequest("PATCH", $endpoint, $data);
		return $response;
	}
	private function DELETErequest($endpoint)
	{
		return $this->curlRequest("DELETE", $endpoint);
	}
	public function getUsers()
	{
		return $this->GETrequest('users/');
	}
	public function getUser(int $id)
	{
		return $this->GETrequest('users/' . $id);
	}
	public function getPosts($userId = null)
	{
		if (is_null($userId)) {
			// Получение всех постов
			return $this->GETrequest('posts/');
		}
		// Получение постов пользователя
		return $this->GETrequest('users/' . $userId . '/posts/');
	}
	public function getPost($id)
	{
		return $this->GETrequest('posts/' . $id);
	}

	public function getTodos($userId = null)
	{
		$response = null;
		if (is_null($userId)) {
			// Получение всех заданий
			$response = $this->GETrequest('todos/');
		} else {
			// Получение заданий определенного пользователя
			$response = $this->GETrequest('users/' . $userId . '/todos');
		}
		return $response;
	}
	public function getTodo($id)
	{
		return $this->GETrequest('todos/' . $id);
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

		return $this->POSTrequest(
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
		return $this->PATCHrequest('posts/' . $postId, json_encode($data));
	}
	public function deletePost($postId)
	{
		return $this->DELETErequest('posts/' . $postId);
	}

}