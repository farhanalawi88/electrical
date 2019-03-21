<?php
session_start();
include "config/inc.connection.php";

 	$txtUsername 	= $_POST['username'];
	$txtPassword	= $_POST['password'];
	
	$txtUsername	= mysql_real_escape_string($txtUsername);
	$txtPassword 	= mysql_real_escape_string($txtPassword);
		
	$cekLogin		= mysql_query("SELECT * FROM ms_user WHERE username_user='".$txtUsername."' AND password_user='".md5($txtPassword)."' AND status_user='Active'");
	if(mysql_num_rows($cekLogin)==1){
		$login = mysql_fetch_array($cekLogin);
		$_SESSION['kode_user'] 	= $login['kode_user'];
		
		echo '<script>window.location="admin.php"</script>';
		
	}else{
		$_SESSION['pesan'] = 'Username dan password anda salah';
		echo '<script>window.location="index.php"</script>';
	}

?>