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
<h4 style="margin:0px 0px 0px 0px; font-weight:bold"><b>LAPORAN RETUR PEMBELIAN</b></h4>
<h4 style="margin:0px 0px 0px 0px">PERIODE : <?php echo IndonesiaTgl($_GET['awal'])?> S/D <?php echo IndonesiaTgl($_GET['akhir'])?></h4>
</div>
<br>
<table width="100%" class="table-list">
	<tr>
	  <th width="2%"><div align="center">No</div></th>
		<th width="11%" class="hidden-phone"><div align="center">Tgl. Transaksi</div></th>
		<th width="10%"><div align="center">No. Transaksi</div></th>
		<th width="11%" class="hidden-phone">No. Pembelian</th>
		<th width="27%" class="hidden-phone">Nama Supplier</th>
		<th width="19%" class="hidden-phone">Nama Kasir</th>
		<th width="20%" class="hidden-phone">Keterangan</th>
	</tr>
	<?php
	$tglAwal		= $_GET['awal'];
	$tglAkhir		= $_GET['akhir'];
											
	$dataSql 		= mysql_query("SELECT
									a.tgl_retur_beli,
									a.kode_retur_beli,
									a.kode_pembelian,
									d.kode_supplier,
									d.nama_supplier,
									b.kode_user,
									b.nama_user,
									a.keterangan_retur_beli
									FROM tr_retur_beli a 
									INNER JOIN ms_user b ON a.kode_user=b.kode_user
									INNER JOIN tr_pembelian c ON a.kode_pembelian=a.kode_pembelian
									INNER JOIN ms_supplier d ON c.kode_supplier=d.kode_supplier
									WHERE date(a.tgl_retur_beli) BETWEEN '$tglAwal' AND '$tglAkhir' 
									GROUP BY a.kode_retur_beli
									ORDER BY a.tgl_retur_beli DESC");
	$nomor  				= 0;
	while($dataRow			= mysql_fetch_array($dataSql)){	
		$nomor ++;
	?>
	<tr>
		<td><div align="center"><?php echo $nomor;?></div></td>
		<td class="hidden-phone"><div align="center"><?php echo indonesiaTgl($dataRow ['tgl_retur_beli']); ?> </div></td>
		<td><?php echo $dataRow ['kode_retur_beli']; ?></td>
		<td><?php echo $dataRow ['kode_pembelian']; ?></td>
		<td class="hidden-phone"><?php echo $dataRow ['kode_supplier']; ?> - <?php echo $dataRow ['nama_supplier']; ?></td>
		<td class="hidden-phone"><?php echo $dataRow ['kode_user']; ?> - <?php echo $dataRow ['nama_user']; ?></td>
		<td class="hidden-phone"><?php echo $dataRow ['keterangan_retur_beli']; ?></td>
	</tr>
	<?php } ?>
</table>
