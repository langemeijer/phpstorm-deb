#!/usr/bin/php
<?php

file_put_contents('/tmp/phpstorm.commandline', $argv[1]);

if ($argc === 2 && preg_match('(^phpstorm:\/\/open\?file=(.*)\&line=([0-9]+)\/?$)', $argv[1], $matches)) {

	$fileName = escapeshellarg(urldecode($matches[1]));
	$lineNumber = escapeshellarg(urldecode($matches[2]));

	system("/opt/PhpStorm/bin/phpstorm --line " . $lineNumber . " " . $fileName);
} else {

	array_shift($argv);
	$cmdLine = implode(" ", array_map('escapeshellarg', $argv));

	system("/opt/PhpStorm/bin/phpstorm " . $cmdLine);
}

