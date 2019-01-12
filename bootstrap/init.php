<?php

if (!defined("__TEARES_INIT")):
	define("__TEARES_INIT", 1);

	require __DIR__."/../config/init.php";

	if (!defined("BASEPATH")) {
		exit("BASEPATH is not defined yet!\n");
	}

	/**
	 * @param string $class
	 * @return void
	 */
	function tearesInternalClassAutoloader(string $class): void
	{
		$class = str_replace("\\", "/", $class);
		if (file_exists($f = BASEPATH."/src/classes/{$class}.php")) {
			require $f;
		}
	}

	spl_autoload_register("tearesInternalClassAutoloader");

endif;