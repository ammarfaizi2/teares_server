<?php

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
	$_SERVER["REMOTE_ADDR"] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

require __DIR__."/../bootstrap/web_init.php";

(new Main)->run();
