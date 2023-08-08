<?php
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
	public function execute($method, $endpoint, $data = null)
	{

		curl_reset($this->curl);

		curl_setopt($this->curl, CURLOPT_URL, $this->apiURL . $endpoint);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		switch ($method) {

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

            case self::GET:
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
}