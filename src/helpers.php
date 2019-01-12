<?php

if (!function_exists("error_api")) {
	/**
	 * @param string $msg
	 * @param int $httpCode
	 * @return void
	 */
	function error_api(string $msg, int $httpCode = 400): void
	{
		http_response_code($httpCode);

		print json_encode(
			[
				"status" => "error",
				"code" => $httpCode,
				"message" => $msg
			],
			JSON_PARAMETER
		);

		exit;
	}
}
