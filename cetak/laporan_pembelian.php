<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../assets/css/metro.css" rel="stylesheet" />
<link href="../assets/css/style.css" rel="stylesheet" />

<body OnLoad="window.print()" OnFocus="window.close()">

<?php
	include_once "../config/inc.connection.php";
	include_once "../config/inc.library.php";
	
	$tokoSql = "SELECT * FROM ms_toko ";
	$tokoQry = mysql_query($tokoSql, $koneksidb)  or die ("Query toko salah : ".mysql_error());
	$tokoRow = mysql_fetch_array($tokoQry);	
	
?>
<div align="center" style="margin-bottom:15px">
<h3 style="margin:0px 0px 0px 0px; font-weight:bold"><strong><?php echo $tokoRow['nama_toko']; ?></strong></h3>
<h4 style="margin:0px 0px 0px 0px"><?php echo $tokoRow['alamat_toko'] ?>, Telp: <?php echo $tokoRow['telp_toko'] ?>, Email: <?php echo $tokoRow['email_toko'] ?></h4>
<h4 style="margin:0px 0px 0px 0px; font-weight:bold"><b>LAPORAN TRANSAKSI PEMBELIAN</b></h4>
<h4 style="margin:0px 0px 0px 0px">PERIODE : <?php echo IndonesiaTgl($_GET['awal'])?> S/D <?php echo IndonesiaTgl($_GET['akhir'])?></h4>
</div>
<br>
<table width="100%" class="table-list">
	<tr>
		<th width="3%"><div align="center">No</div></th>
		<th width="12%" class="hidden-phone"><div align="center">Tgl. Transaksi</div></th>
		<th width="11%"><div align="center">No. Transaksi</div></th>
		<th width="24%" class="hidden-phone">Nama Supplier</th>
		<th width="22%" class="hidden-phone">Nama Kasir</th>
		<th width="17%" class="hidden-phone">Keterangan</th>
		<th width="11%"><div align="right">Total Pembelian</div></th>
	</tr>
	<?php
	$tglAwal		= $_GET['awal'];
	$tglAkhir		= $_GET['akhir'];
											
	$dataSql 		= mysql_query("SELECT * FROM tr_pembelian a 
									INNER JOIN ms_user b ON a.kode_user=b.kode_user
									INNER JOIN ms_supplier c ON a.kode_supplier=c.kode_supplier
									WHERE date(a.tgl_pembelian) BETWEEN '$tglAwal' AND '$tglAkhir' 
									ORDER BY a.tgl_pembelian DESC");
	$nomor  				= 0;
	$subtotal 				= 0;
	while($dataRow			= mysql_fetch_array($dataSql)){	
		$nomor ++;
		$subtotal 			= $subtotal + $dataRow['total_pembelian'];
	?>
	<tr>
		<td><div align="center"><?php echo $nomor;?></div></td>
		<td class="hidden-phone"><div align="center"><?php echo indonesiaTgl($dataRow ['tgl_pembelian']); ?> </div></td>
		<td><div align="center"><?php echo $dataRow ['kode_pembelian']; ?></div></td>
		<td class="hidden-phone"><?php echo $dataRow ['kode_supplier']; ?> - <?php echo $dataRow ['nama_supplier']; ?></td>
		<td class="hidden-phone"><?php echo $dataRow ['kode_user']; ?> - <?php echo $dataRow ['nama_user']; ?></td>
		<td class="hidden-phone"><?php echo $dataRow ['keterangan_pembelian']; ?></td>
		<td><div align="right"><?php echo format_angka($dataRow ['total_pembelian']); ?></div></td>
	</tr>
	<?php } ?>
	<tr>
		<th colspan="6"><div align="right">Grand Total : </div></th>
		<th width="11%"><div align="right"><?php echo format_angka($subtotal) ?></div></th>
	</tr>
</table>
