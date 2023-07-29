<?php

class ErrorHandler
{
	public static function JSONResponse($httpStatusCode, $errorMessage)
	{
		http_response_code($httpStatusCode);
		return json_encode([
			'errors' => [
				'statusCode' => $httpStatusCode,
				'errorMessage' => $errorMessage
			]
		]);


	}
}