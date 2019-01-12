<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @version 0.0.1
 */
final class Main
{	
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->auth();
	}

	/**
	 * @return void
	 */
	private function auth(): void
	{
		if (!isset($_SERVER["HTTP_X_TEARES_DAEMON"])) {
			goto _unauthorized;
		}

		if ($_SERVER["HTTP_X_TEARES_DAEMON"] !== API_SECRET) {
			goto _unauthorized;
		}

		return;

_unauthorized:
		error_api("Unauthorized", 401);	
	}

	/**
	 *
	 */
	public function run(): void
	{
		if (isset($_GET["action"])) {
			switch ($_GET["action"]) {
				case "ping":
					$this->ping();
					break;
				
				default:
					error_api("Invalid action \"{$_GET["action"]}\"", 400);
					break;
			}
			exit;
		}

		error_api("Action required", 400);
	}

	/**
	 *
	 */
	private function ping(): void
	{
		$handle = fopen(sprintf("%s/logs/{$_SERVER["REMOTE_ADDR"]}.log", STORAGE_PATH), "a");
		fwrite($handle, sprintf("%s\t%s\n", dechex(time()), "ping"));
	}
}
