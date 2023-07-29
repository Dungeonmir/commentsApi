<?php
class Api
{
	private $apiURL;
	function __construct($URL)
	{
		$this->apiURL = $URL;
	}
	public function getData($endpoint)
	{
		$curl = curl_init($this->apiURL . $endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);

		return $response;

	}
	public function getUsers()
	{
		return $this->getData('users/');
	}

}