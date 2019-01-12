#!/usr/bin/env php
<?php

require __DIR__."/config/log.php";

foreach (glob(__DIR__."/storage/logs/*.log") as $file) {
	if (filesize($file) >= MAX_LOG_ARCHIVES) {
		$basename = basename($file);
		if (file_exists(__DIR__."/storage/logs/tmpd/{$basename}.count")) {
			$i = ((int)file_get_contents(__DIR__."/storage/logs/tmpd/{$basename}.count"));
		} else {
			$i = 1;
		}

		if ($i > MAX_LOG_FILE) {
			unlink(__DIR__."/storage/logs/archived/{$basename}_1.tar.gz");
			for ($ii=2; $ii <= MAX_LOG_FILE; $ii++) {
				$jj = $ii-1;
				rename(
					__DIR__."/storage/logs/archived/{$basename}_{$ii}.tar.gz",
					__DIR__."/storage/logs/archived/{$basename}_{$jj}.tar.gz"
				);
			}
			$i = MAX_LOG_FILE;
		}

		rename($file, $logFilep = __DIR__."/storage/logs/tmpd/{$basename}_{$i}");
		$logFile = escapeshellarg(basename($logFilep));
		$tarFile = escapeshellarg(__DIR__."/storage/logs/archived/{$basename}_{$i}.tar.gz");
		$dir = escapeshellarg(__DIR__."/storage/logs/tmpd");		
		shell_exec("env GZIP=-9 tar -C {$dir} -cvzf {$tarFile} {$logFile}");
		unlink($logFilep);
		file_put_contents(__DIR__."/storage/logs/tmpd/{$basename}.count", ((string)$i+1));
	}
}
