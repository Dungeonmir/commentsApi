<?php
include './Request.class.php';
class User
{
	private $api;
	public function __construct($url)
	{
		$this->api = new Request($url);
	}
	public function getTodos($userId = null)
	{
		$response = null;
		if (is_null($userId)) {
			// Получение всех заданий
			$response = $this->api->GETrequest('todos/');
		} else {
			// Получение заданий определенного пользователя
			$response = $this->api->GETrequest('users/' . $userId . '/todos');
		}
		return $response;
	}
	public function getTodo($id)
	{
		return $this->api->GETrequest('todos/' . $id);
	}

}