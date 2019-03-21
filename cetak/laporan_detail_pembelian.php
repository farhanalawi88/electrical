<link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="../assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
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
<h4 style="margin:0px 0px 0px 0px; font-weight:bold"><b>LAPORAN DETAIL PEMBELIAN</b></h4>
<h4 style="margin:0px 0px 0px 0px">PERIODE : <?php echo IndonesiaTgl($_GET['awal'])?> S/D <?php echo IndonesiaTgl($_GET['akhir'])?></h4>
</div>
<br>
<table width="100%" class="table-list">
	<tr>
		<th width="2%"><div align="center">No</div></th>
		<th width="10%" class="hidden-phone"><div align="center">Tanggal</div></th>
		<th width="10%"><div align="center">Nomor</div></th>
		<th width="12%" class="hidden-phone"><div align="center">Kode Barang</div></th>
		<th width="40%" class="hidden-phone">Nama Barang</th>
		<th width="10%" class="hidden-phone"><div align="right">Harga</div></th>
	  <th width="8%" class="hidden-phone"><div align="center">Jumlah</div></th>
		<th width="8%"><div align="right">Subtotal</div></th>
	</tr>
	<?php
		
		$tglAwal		= $_GET['awal'];
		$tglAkhir		= $_GET['akhir'];		
		$dataSql 		= mysql_query("SELECT * FROM tr_pembelian_item a 
										INNER JOIN tr_pembelian b ON a.kode_pembelian=b.kode_pembelian
										INNER JOIN ms_barang c ON a.kode_barang=c.kode_barang
										WHERE date(b.tgl_pembelian) BETWEEN '$tglAwal' AND '$tglAkhir' 
										ORDER BY b.tgl_pembelian DESC");
		$nomor  		= 0;
		$subtotal 		= 0;
		$total			= 0;
		$harga			= 0;
		$jumlah			= 0;
		while($dataRow	= mysql_fetch_array($dataSql)){	
			$nomor ++;
			$total		= intval($dataRow ['jumlah_pembelian']*$dataRow['harga_pembelian']);
			$subtotal 	= $subtotal + $total;
			$jumlah 	= $jumlah + $dataRow ['jumlah_pembelian'];
			$harga	 	= $harga + $dataRow ['harga_pembelian'];
	?>
	<tr>
		<td><div align="center"><?php echo $nomor;?></div></td>
		<td class="hidden-phone"><div align="center"><?php echo indonesiaTgl($dataRow ['tgl_pembelian']); ?> </div></td>
		<td><?php echo $dataRow ['kode_pembelian']; ?></td>
		<td class="hidden-phone"><div align="center"><?php echo $dataRow ['kode_barcode']; ?></div></td>
		<td class="hidden-phone"><?php echo $dataRow ['nama_barang']; ?></td>
		<td><div align="right"><?php echo format_angka($dataRow ['harga_pembelian']); ?></div></td>
		<td><div align="center"><?php echo format_angka($dataRow ['jumlah_pembelian']); ?></div></td>
		<td><div align="right"><?php echo format_angka($total); ?></div></td>
	</tr>
	<?php } ?>
	<tr>
		<th colspan="5"><div align="right">Subtotal : </div></th>
		<th width="10%" class="hidden-phone"><div align="right"><?php echo format_angka($harga) ?></div></th>
	  	<th width="8%" class="hidden-phone"><div align="center"><?php echo format_angka($jumlah) ?></div></th>
		<th width="8%"><div align="right"><?php echo format_angka($subtotal) ?></div></th>
	</tr>
</table>
