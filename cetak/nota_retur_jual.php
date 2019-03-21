<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../assets/css/metro.css" rel="stylesheet" />
<link href="../assets/css/style.css" rel="stylesheet" />
<body OnLoad="window.print()" OnFocus="window.close()">
<?php
	include "../config/inc.connection.php";
	include "../config/inc.library.php";
				
	$kodeTransaksi = $_GET['id'];
				
	$beliSql = "SELECT
				a.kode_retur_jual,
				a.tgl_retur_jual,
				b.kode_penjualan,
				d.kode_user,
				d.nama_user,
				a.keterangan_retur_jual
				FROM tr_retur_jual a
				INNER JOIN tr_penjualan b ON a.kode_penjualan=b.kode_penjualan
				INNER JOIN ms_user d ON a.kode_user=d.kode_user
				AND a.kode_retur_jual='$kodeTransaksi'";
	$beliQry = mysql_query($beliSql, $koneksidb)  or die ("Query jual salah : ".mysql_error());
	$beliRow = mysql_fetch_array($beliQry);
	
	$tokoSql = "SELECT * FROM ms_toko ";
	$tokoQry = mysql_query($tokoSql, $koneksidb)  or die ("Query toko salah : ".mysql_error());
	$tokoRow = mysql_fetch_array($tokoQry);
?>
<div align="center">
<h4 style="margin-bottom:0px; font-weight: bold;"><?php echo strtoupper($tokoRow['nama_toko']) ?></h4>
<small style="margin-top:0px"><?php echo $tokoRow['alamat_toko'] ?>, Telp: <?php echo $tokoRow['telp_toko'] ?>, Email: <?php echo $tokoRow['email_toko'] ?></small> 
<div style="border-bottom:1px dashed #000;"></div>
<b style="margin-top:0px; text-decoration:underline">NOTA RETUR PENJUALAN</b><br>
</div>
 <table style="font-size: 11px">
  <tr>
    <td width="4%">Nomor</td>
    <td width="96%">: <span style="margin-top:0px"><?php echo $beliRow['kode_retur_jual'] ?></span></td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>: <span style="margin-top:0px"><?php echo $beliRow['tgl_retur_jual'] ?></span></td>
  </tr>
  <tr>
    <td width="4%">Struk</td>
    <td width="96%">: <span style="margin-top:0px"><?php echo $beliRow['kode_penjualan'] ?></span></td>
  </tr>
  <tr>
    <td>Kasir</td>
    <td>: <span style="margin-top:0px"><?php echo $beliRow['nama_user'] ?></span></td>
  </tr>
  <tr>
    <td colspan="2"><div style="border-bottom:1px dashed #000;"></div></td>
  </tr>
</table>
<table width="100%">
  
  <?php
		$listBarangSql = "SELECT * FROM tr_retur_jual_item a
							INNER JOIN ms_barang b ON a.kode_barang=b.kode_barang 
							WHERE a.kode_retur_jual='$kodeTransaksi'
							ORDER BY b.kode_barang ASC";
		$listBarangQry = mysql_query($listBarangSql, $koneksidb)  or die ("Query list barang salah : ".mysql_error());
		$total 	= 0; 
		$qtyBrg = 0; 
		$itm	= 0;
		while ($listBarangRow = mysql_fetch_array($listBarangQry)) {
		$subSotal 	= $listBarangRow['jumlah_retur_jual'] * intval($listBarangRow['harga_retur_jual']);
		$total 		= $total + $subSotal;
		$qtyBrg 	= $qtyBrg + $listBarangRow['jumlah_retur_jual'];	
		$itm	 	= $itm + $listBarangRow['jumlah_retur_jual'];	
	?>
  <tr>
    <td width="2%"><div align="center"><?php echo format_angka($listBarangRow['jumlah_retur_jual']); ?></div></td>
    <td width="98%"><div align="left"><?php echo $listBarangRow['nama_barang']; ?></div></td>
	<td width="98%"><div align="left"><?php echo format_angka($listBarangRow['harga_retur_jual']); ?></div></td>
	<td><div align="right"><?php echo format_angka($subSotal); ?></div></td>
  </tr>
  <?php } ?>
</table>
<div style="border-bottom:1px dashed #000;"></div>
<table width="100%" border="0">
  <tr>
    <td width="60%"><div align="right">Total Item  </div></td>
    <td width="1%">:</td>
    <td width="39%"><div align="right"><?php echo format_angka($itm); ?></div></td>
  </tr>
  <tr>
    <td><div align="right">Grand Total </div></td>
    <td>:</td>
    <td><div align="right"><?php echo format_angka($total); ?></div></td>
  </tr>
</table>
<div style="border-bottom:1px dashed #000;"></div>
<div align="center" style="margin-top:20px">
<b>TERIMA KASIH</b><br>
<?php echo $tokoRow['keterangan_toko'] ?>
</div>



