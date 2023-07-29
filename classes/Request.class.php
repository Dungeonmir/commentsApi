<?php
include './classes/ErrorHandler.class.php';
class Request
{
	private $apiURL;
	private $curl;

	const POST = "POST";
	const GET = "GET";
	const PATCH = "PATCH";
	const DELETE = "DELETE";
	function __construct($URL)
	{
		$this->apiURL = $URL;
		$this->curl = curl_init();
	}
	private function curlRequest($method, $endpoint, $data = null)
	{

		curl_reset($this->curl);

		curl_setopt($this->curl, CURLOPT_URL, $this->apiURL . $endpoint);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);


		switch ($method) {

			case self::GET:
				break;

			case self::POST:
				curl_setopt($this->curl, CURLOPT_POST, true);
				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
				break;
			case self::PATCH:
				curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
				break;

			case self::DELETE:
				curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;

			default:
				break;
		}
		$response = curl_exec($this->curl);

		$code = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
		if ($code > 220) {
			$response = ErrorHandler::JSONResponse(500, "The requst wasn't succesful.");
		}
		return $response;

	}
	public function GETrequest($endpoint)
	{
		$response = $this->curlRequest($this::GET, $endpoint);
		if (!$response) {
			return ErrorHandler::JSONResponse(404, 'Resource not found');
		}
		return $response;

	}
	public function POSTrequest($endpoint, $data)
	{
		$response = $this->curlRequest($this::POST, $endpoint, $data);
		return $response;
	}
	public function PATCHrequest($endpoint, $data)
	{
		$response = $this->curlRequest($this::PATCH, $endpoint, $data);
		return $response;
	}
	public function DELETErequest($endpoint)
	{
		return $this->curlRequest($this::DELETE, $endpoint);
	}
}