<?php
# Konek ke Web Server Lokal
$myHost	= "192.168.2.9";
$myUser	= "root";
$myPass	= "password";
$myDbs	= "electrical_db";

# Konek ke Web Server Lokal
$koneksidb	= mysql_connect($myHost, $myUser, $myPass);
if (! $koneksidb) {
  echo "Failed Connection !";
}

# Memilih database pd MySQL Server
mysql_select_db($myDbs, $koneksidb) or die ("Database not Found !");
?>