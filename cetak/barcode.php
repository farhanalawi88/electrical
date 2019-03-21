<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../assets/css/metro.css" rel="stylesheet" />
<link href="../assets/css/style.css" rel="stylesheet" />
<body OnLoad="window.print()" OnFocus="window.close()">
<?php
include		 "../config/bar128.php";	

$dataKode	= $_GET['id'];
$dataJumlah	= 10;
	
for($a=1; $a<=$dataJumlah; $a++)
{
echo '<div  style="padding:5px;margin:5px">';
echo bar128(stripslashes($dataKode));
echo '</div>';
}

?>