<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @version 0.0.1
 */
class ShellCmdResult
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->run();
	}

	/**
	 * @return void
	 */
	public function run(): void
	{
		if (isset($_FILES["file"]["tmp_name"])) {
			$time = time();
			$rdn = rand(10000, 99999);
			move_uploaded_file(
				$_FILES["file"]["tmp_name"], 
				STORAGE_PATH."/queue/shell_cmd/result/{$_SERVER["REMOTE_ADDR"]}__{$time}__{$rdn}.bin"
			);
		}
	}	
}