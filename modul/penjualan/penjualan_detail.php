<?php				
	$kodeTransaksi = $_GET['id'];				
	$beliSql = "SELECT * FROM tr_penjualan a
				LEFT JOIN ms_expedisi b ON a.kode_expedisi=b.kode_expedisi
				INNER JOIN ms_user c ON a.kode_user=c.kode_user
				AND a.kode_penjualan='".$kodeTransaksi."'";
	$beliQry = mysql_query($beliSql, $koneksidb)  or die ("Query pembelian salah : ".mysql_error());
	$beliRow = mysql_fetch_array($beliQry);
?>
<div class="portlet">
	<div class="portlet-title">
	<div class="caption"><span class="caption-subject uppercase bold">Nota Pembayaran Penjualan</span></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label class="control-label">No. Transaksi :</label>
					<div class="controls">
						<div class="input-icon left">
						<i class="fa fa-qrcode"></i>
						<input class="form-control" type="text" value="<?php echo $beliRow['kode_penjualan']; ?>" disabled="disabled"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Tgl. Transaksi :</label>
					<div class="controls">
						<div class="input-icon left">
								<i class="icon-calendar"></i>
							<input class="form-control" type="text" value="<?php echo IndonesiaTgl($beliRow['tgl_penjualan']); ?>" disabled="disabled"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Nama Pelanggan :</label>
					<div class="controls">
						<div class="input-icon left">
							<i class="icon-user"></i>
							<input class="form-control" type="text" value="<?php echo $beliRow['nama_customer']; ?>" disabled="disabled"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Nama Operator :</label>
					<div class="controls">
						<div class="input-icon left">
						<i class="icon-user"></i>
						<input class="form-control" type="text" value="<?php echo $beliRow['kode_user']; ?> - <?php echo $beliRow['nama_user']; ?>" disabled="disabled"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<table class="table table-hover table-condensed table-bordered" width="100%" id="sample_4">
			<thead>
				<tr>
			  	  	<th class="hidden-phone" width="34"><div align="center">NO</div></th>
					<th width="152"><div align="center">KODE BARANG</div></th>
					<th width="660" class="hidden-phone"><div align="left">NAMA BARANG</div></th>
				  	<th class="hidden-phone" width="189"><div align="right">HARGA JUAL</div></th>
				  	<th class="hidden-phone" width="101"><div align="center">JUMLAH</div></th>
				  	<th width="134"><div align="right">SUBTOTAL</div></th>
				</tr>
			</thead>
			<tbody>
			<?php
					$listBarangSql = "SELECT * FROM tr_penjualan_item a
										LEFT JOIN tr_penjualan b ON a.kode_penjualan=b.kode_penjualan 
										INNER JOIN ms_barang c ON a.kode_barang=c.kode_barang
									  	WHERE a.kode_penjualan='$kodeTransaksi'
									  	ORDER BY c.kode_barang ASC";
					$listBarangQry = mysql_query($listBarangSql, $koneksidb)  or die ("Query list barang salah : ".mysql_error());
					$total 	= 0; 
					$qtyBrg = 0; 
					$nomor	= 0;
					$qtyPPN	= 0;
					while ($listBarangRow = mysql_fetch_array($listBarangQry)) {
					$subSotal 	= $listBarangRow['jumlah_penjualan'] * intval($listBarangRow['harga_penjualan']);
					$total 		= $total + $subSotal;
					$qtyBrg 	= $qtyBrg + $listBarangRow['jumlah_penjualan'];
					$nomor++;
			?>
				<tr>
					<td class="hidden-phone"><div align="center"><?php echo $nomor; ?></div></td>
					<td><div align="center"><?php echo $listBarangRow['kode_barcode']; ?></div></td>
					<td><div align="left"><?php echo $listBarangRow['nama_barang']; ?></div></td>
					<td class="hidden-phone"><div align="right"><?php echo format_angka2($listBarangRow['harga_penjualan']); ?></div></td>
					<td class="hidden-phone"><div align="center"><?php echo $listBarangRow['jumlah_penjualan']; ?></div></td>
					<td><div align="right"><?php echo format_angka2($subSotal); ?></div></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<hr>
		<div class="row">
			<div class="col-md-3 hidden-phone">
				<div class="form-group">
					<label class="control-label">Nama Expedisi :</label>
					<div class="controls">
					<input class="form-control" type="text" value="<?php echo $beliRow['nama_expedisi']; ?>" disabled="disabled"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label">No. Referensi :</label>
					<div class="controls">
					<input class="form-control" type="text" value="<?php echo $beliRow['no_referensi']; ?>" disabled="disabled"/>
					</div>
				</div>
			</div>
			<div class="col-md-6 hidden-phone">
				<div class="form-group">
					<label class="control-label">Alamat :</label>
					<div class="controls">
					<textarea class="form-control" rows="4" type="text" disabled="disabled"/><?php echo $beliRow['alamat_customer']; ?></textarea>
					</div>
				</div>
			</div>
			<div class="col-md-3" align="right">
				<div class="row align-reverse">
                    <div class="col-md-8 name"><span class="caption-subject uppercase">Total : </span></div>
                    <div class="col-md-3 value bold"><?php echo format_angka2($total); ?></div>
                </div>
                <div class="row align-reverse">
                    <div class="col-md-8 name"><span class="caption-subject uppercase">Jasa Kirim :</span></div>
                    <div class="col-md-3 value bold"><?php echo format_angka2($beliRow['total_ongkir']); ?></div>
                </div>
                ------------------------------------------
                <div class="row align-reverse">
                    <div class="col-md-8 name"><span class="caption-subject uppercase">Subtotal :</span></div>
                    <div class="col-md-3 value bold"><?php echo format_angka2($total+$beliRow['total_ongkir']); ?></div>
                </div>
			</div>
		</div>
		<br>
		<div class="form-actions">
			<a href="?page=addpjl" class="btn blue hidden-phone" ><i class="icon-plus"></i> Tambah Penjualan</a>
			<a href="./export/sales_report.php?id=<?php echo $kodeTransaksi; ?>" class="btn blue" target="_BLANK"><i class="icon-printer"></i> Cetak Nota</a>
			<a href="?page=dtpjl" class="btn blue hidden-phone" ><i class="icon-basket"></i> Data Penjualan</a>
		</div>	
  </div>
</div>
		  	