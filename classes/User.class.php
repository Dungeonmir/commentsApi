<?php
include 'Request.class.php';
class User
{
	private $api;
	public function __construct($url)
	{
		$this->api = new Request($url);
	}

	public function getUsers()
	{
		return $this->api->GETrequest('users/');
	}
	public function getUser(int $id)
	{
		return $this->api->GETrequest('users/' . $id);
	}

}