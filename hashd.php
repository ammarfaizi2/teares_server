<?php

$a = glob(__DIR__."/storage/logs/archived/*.tar.gz");

foreach ($a as $file) {
	print($file."\t".sha1_file($file)."\n");
}

