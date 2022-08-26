#!/usr/bin/env php
<?php
echo 'Cleaning up old installs' . PHP_EOL;
array_map('unlink', glob('*.tar.gz'));
array_map('unlink', glob('*.sha256'));

echo 'Downloading new version' . PHP_EOL;
$url = 'https://data.services.jetbrains.com/products/releases?code=PS&latest=true';
$latestRelease = file_get_contents($url);

$data = json_decode($latestRelease, true);
$link = $data['PS'][0]['downloads']['linux']['link'];
$md5sum = $data['PS'][0]['downloads']['linux']['checksumLink'];

echo 'Downloading $link' . PHP_EOL;

$filename = basename($link);
$checksumName = basename($md5sum);

curlDownload($link, __DIR__ . '/' . $filename);
echo 'Downloading $md5sum' . PHP_EOL;
curlDownload($md5sum, __DIR__ . '/' . $checksumName);

echo 'Verifying checksum';
exec('sha256sum -c ' . escapeshellarg(__DIR__ . '/' . $checksumName), $output, $exitcode);

if ($exitcode !== 0) {
  echo 'Checksum failed!';
  exit(1);
}

shell_exec(escapeshellcmd(__DIR__ . '/update.sh'));
echo 'Download and update complete. Execute the following commands to build and update the new php version' . PHP_EOL;

echo 'Building latest version...' . PHP_EOL;
chdir(__DIR__);
exec('debuild -us -uc -b');

$debname = str_replace('-', '_', strtolower(basename($filename, '.tar.gz')) . '_all.deb');
echo 'Build complete. Install the new version by using' . PHP_EOL;
echo 'sudo dpkg -i ../' . $debname;

function curlDownload($url, $destination)
{
  $file = fopen($destination, 'w+');
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_FILE, $file);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch);

  fclose($file);
  curl_close($ch);
}
