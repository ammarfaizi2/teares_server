<?php

$host = "0.0.0.0";
$port = 8080;
$docRoot = __DIR__."/public";
$extArgv = "";

$fileDescriptors = [
	["pipe", "r"],
	["file", "php://stdout", "w"],
	["file", "php://stdout", "w"]
];

$host = escapeshellarg($host);
$port = escapeshellarg((string)$port);
$docRoot = escapeshellarg($docRoot);

$cmd = PHP_BINARY." {$extArgv} -S {$host}:{$port} -t {$docRoot}";

proc_close(proc_open($cmd, $fileDescriptors, $pipes));
unset($cmd, $fileDescriptors, $pipes);
