#!/usr/bin/env php
<?php
 $dir = dirname(__FILE__);

 echo "Cleaning up old installs\n";
 array_map('unlink', glob("*.tar.gz"));
 array_map('unlink', glob("*.sha256"));

 echo "Downloading new version\n";
 $url = "https://data.services.jetbrains.com/products/releases?code=PS&latest=true";
 $result = curlDownload($url);

$data = json_decode($result, true);
$link = $data["PS"][0]["downloads"]["linux"]["link"];
$md5sum = $data["PS"][0]["downloads"]["linux"]["checksumLink"];

echo "Downloading $link\n";

$filename = basename($link);
$checksumName = basename($md5sum);

curlDownload($link, $dir."/".$filename);
echo "Downloading $md5sum\n";
curlDownload($md5sum, $dir."/".$checksumName);

echo "Verifying checksum";
$exitcode = "";
$output = "";
exec ("sha256sum -c $dir/$checksumName", $output, $exitcode);

if ((int)$exitcode !== 0)
{
  echo "Checksum failed!";
  exit;
}

shell_exec($dir."/update.sh");
echo "Download and update complete. Execute the following commands to build and update the new php version\n";

echo "Building latest version.. \n";
chdir ($dir);
exec("debuild -us -uc -b");

$debname = str_replace("-","_",strtolower(basename($filename,".tar.gz"))."_all.deb");
echo "Build complete. Install the new version by using \n";
echo "sudo dpkg -i ../$debname";

function curlDownload($url, $destination = null)
{
 $ch = curl_init();
 //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 $result=curl_exec($ch);
 
 // Closing
 curl_close($ch);
 if ($destination)
 {
   $file = fopen($destination, "w+");
   fputs($file, $result);
   fclose($file);
 }

 return $result;
}
